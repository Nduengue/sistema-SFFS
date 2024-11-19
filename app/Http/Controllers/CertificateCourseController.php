<?php

namespace App\Http\Controllers;

use App\Models\CertificateCourse;
use App\Http\Requests\StoreCertificateCourseRequest;
use App\Models\CertificateCourseGrade;
use App\Models\DocumentSetting;
use App\Models\GradeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\HeaderUtils;

class CertificateCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificateCourse = CertificateCourse::where("active",true)
                             ->get();

        $data = [
            "data"=>$certificateCourse
        ];
        
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificateCourseRequest $request)
    {
        $data   =   CertificateCourse::create($request->validated());
        $id = $data->id;
        return response()->json([
            "message"=>"Criação de Certificado de aluno Modo Manual !",
            "url"=>route("certificate-course.update",$id)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($certificateCourse)
    {
        $certificateCourse  = CertificateCourse::find($certificateCourse);
        $documentSetting    = DocumentSetting::find(1);


        // Configuração de opções
        $options = new Options();

        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        // Instancia o Dompdf com as opções
        $dompdf = new Dompdf($options);

        $averages           = CertificateCourseGrade::select('subject_id', 'academic_year','grade','student_id', DB::raw('AVG(grade) as average_grade'))
            ->groupBy('subject_id')
            ->where("student_id",$certificateCourse->student_id)
            ->get();

        // Cria uma nova instância do QR Code
        $qrCode = new QrCode('https://www.exemplo.com');
       /*  $qrCode->setSize(300); */

        // Define o escritor como PNG
        $writer = new PngWriter();

        // Gera a imagem do QR Code
        $result = $writer->write($qrCode);

        // Salva a imagem em um arquivo (opcional)
        $result->saveToFile('qrcode.png');
        
        $data =[
            "certificateCourse"=>$certificateCourse,
            "averages"=>$averages,
            "options"=>$options,
            "dompdf"=>$dompdf,
            "documentSetting"=>$documentSetting
        ];

        return view("files.certificate-course",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $certificateCourse)
    {
        //$gradeSetting       = GradeSetting::find(1);
        $certificateCourse  = CertificateCourse::find($certificateCourse);
        foreach ($request->post()["term"] as $rows) {
            /* if($gradeSetting->max >= $rows["grade"]) */
            CertificateCourseGrade::updateOrInsert([
                "certificate_course_id"=>$certificateCourse->id,
                "term"=>"term",
                "subject_id"=>$rows["subject_id"],
                "student_id"=>$certificateCourse->student_id,
            ],[
                "student_id"=>$certificateCourse->student_id,
                "subject_id"=>$rows["subject_id"],
                "grade"=>$rows["grade"],
                "term"=>"term",
                "academic_year"=>$certificateCourse->academic_year,
            ]);
            /* else{
                return response()->json([ 
                    "warning"=>"Nota deve ser"
                ]);
            } */
        }
        return response()->json([
            "message"=>"Criação de Certificado de aluno feito !",
            "open"=>route('certificate-course.show',$certificateCourse->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($certificateCourse)
    {
        $data = CertificateCourse::where("id",$certificateCourse)
                ->update(["active"=>false]);

        if(request()->ajax())
        return response()->json([
            "message"=>"Delete de Certificado de aluno feito!",
            "clear"=>true
        ]);

        return redirect()->back();
    }
}
