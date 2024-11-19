<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginPointRequest;
use App\Models\Point;
use App\Http\Requests\StorePointRequest;
use App\Http\Requests\UpdatePointRequest;
use App\Models\FinishQuiz;
use App\Models\Quiz;
use App\Models\Response;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classroom  =  request()->query("classroom_id",0);
        $student  =  request()->query("student_id",0);
        if($classroom!=0)
        
        $point      =   Point::where("classroom_id",$classroom)
                        ->get();
                        
        if($student!=0)
        
        $point      =   Point::where("student_id",$student)
                        ->get();
        
        if($classroom ==0 && $student==0) 

        $point      =   Point::all();

        $data = [
            "data"=>$point
        ];

        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     */
    public function report()
    {
        /**
         * Get Data
        */
        $classroom =  request()->query("classroom_id",1);
        $student_id =  request()->query("student_id",0);
        $date_start =  request()->query("date_start",date("Y-01-01"));
        $date_end =  request()->query("date_end",date("Y-m-t"));

        if ($student_id==0)
        $point = Point::where("classroom_id",$classroom)
                 ->whereBetween("date",[$date_start,$date_end])
                 ->get();
        else 
        $point = Point::where("classroom_id",$classroom)
                ->where("student_id",$student_id)
                ->whereBetween("date",[$date_start,$date_end])
                ->get();

        foreach ($point as $rows) {
            $rows->countQuestion = Response::where("user_id",$rows->student_id)->count();
        }

        /** Total de presenças */

        if ($student_id==0)
        $TP = Point::where("classroom_id",$classroom)->whereBetween("date",[$date_start,$date_end])->where("point",0)->count();
        else 
        $TP = Point::where("classroom_id",$classroom)->where("student_id",$student_id)->whereBetween("date",[$date_start,$date_end])->where("point",0)->count();
        
        if ($student_id==0)
        $TF = Point::where("classroom_id",$classroom)->whereBetween("date",[$date_start,$date_end])->where("point",1)->count();
        else 
        $TF = Point::where("classroom_id",$classroom)->where("student_id",$student_id)->whereBetween("date",[$date_start,$date_end])->where("point",1)->count();
        
        if ($student_id==0)
        $TQ = FinishQuiz::where("classroom_id",$classroom)->count();
        else 
        $TQ = FinishQuiz::where("classroom_id",$classroom)->where("student_id",$student_id)->count();
        
        
        if ($student_id==0)
        $TI = Response::where("classroom_id",$classroom)->count();
        else 
        $TI = Response::where("classroom_id",$classroom)->where("student_id",$student_id)->count();
        
        
        // Total de pontos (presença + falta)
        $TPS = $TP + $TF;

        // Verifica se o total não é zero para evitar divisão por zero
        if ($TPS > 0) {
            $PP = ($TP / $TPS) * 100; // Porcentagem de presença
            $PF = ($TF / $TPS) * 100; // Porcentagem de falta
        } else {
            $PP = 0;
            $PF = 0;
        }

        $data = [
            "TP"=>$TP,
            "TF"=>$TF,
            "TI"=>$TI,
            "TQ"=>$TQ,
            "PP"=>$PP,
            "PF"=>$PF,
            "MN"=>($TP+$TF+$TQ+$PP+$PF)/5,
            "data"=>$point,
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointRequest $request)
    {
        $point = Point::create($request->validated());

        return response()->json([
            "message"=>"success",
            "data"=>$point
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function loginPoint(StoreLoginPointRequest $request)
    {
        

        // Endpoint da API
        $api_url = 'https://www.app.enanza.ao/api/students/get-data';
        $points=[];

        // Seu token Bearer
        $bearer_token = $request->token;

        // Inicializa o cURL
        $ch = curl_init();

        // Define as opções de cURL
        curl_setopt($ch, CURLOPT_URL, $api_url); // Define a URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
        curl_setopt($ch, CURLOPT_HTTPGET, true); // Método GET

        // Define o cabeçalho com o token Bearer
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $bearer_token,
            'Accept: application/json',
            'Content-Type: application/json'
        ]);

        // Executa a requisição e armazena a resposta
        $response = curl_exec($ch);

        // Verifica se houve erro na requisição
        if (curl_errno($ch)) {
            echo 'Erro na requisição cURL: ' . curl_error($ch);
        } 
        else {
            // Decodifica a resposta JSON em um array associativo
            $students = json_decode($response, true);

            // Percorre cada estudante
            foreach ($students as $student) {
              $id =$student['id'];
                if (!empty($student['registration'])) {
                    foreach ($student['registration'] as $registration) {
                        $point = Point::updateOrCreate(
                            [
                                "date"=>date("Y-m-d"),
                                "classroom_id"=>$registration['class_model']['class_id'],
                                "student_id"=>$id,
                            ],
                            [
                                "student_id"=>$id,
                                "user_id"=>$id,
                                "classroom_id"=>$registration['class_model']['class_id'],
                                "date"=>$request->date,
                                "point"=>$request->point,
                                "token"=>$request->token,
                            ]
                        );
                        array_push($points,$point);
                    }
                } else {
                    echo "Nenhum registro de matrícula encontrado.<br>";
                }
            }
            $data = json_decode($response,true);
        }
        curl_close($ch);

        return response()->json([
            "message"=>"success",
            "data"=>$points
        ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Point $point)
    {
        $data = [
            "data"=>$point
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointRequest $request, Point $point)
    {
        $point->update($request->validated());

        return response()->json(["message"=>"success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Point $point)
    {
        $point->delete();
        return response()->json(["message"=>"success"]);

    }
}
