<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\UpdateStudentDocumentRequest;
use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        // Adicione o valor para `student_status`
        $validatedData['student_status'] = 0;  // 0=Alterável pelo Estudante
        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with(['studentDocuments'])->find($id);
        if ($student) {return response()->json($student);}
        return response()->json(['message' => 'Student not found.'], 404);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);
        // Obtenha todos os dados validados
        $data = $request->validated();
        // Remova o campo 'email' dos dados antes da atualização
        unset($data['email']);
        // Atualize o aluno com os dados filtrados
        $student->update($data);
        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student->delete();
        return response()->json(null, 204);
    }

    /**
     * Controladores para serem acessadas pelos Estudantes
     */

    public function showStudentData(string $id)
    {
        $student = Student::with('studentDocuments')->where('user_id', $id)->first();
        if ($student) {return response()->json($student);}
        return response()->json(['message' => 'Student not found.'], 404);
    }

    public function storeDataStudent(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        // Adicione o valor para `student_status`
        $validatedData['student_status'] = 0;  // 0=Alterável pelo Estudante
        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    public function updateStudent(UpdateStudentRequest $request, string $id)
    {
        $student = Student::where('user_id', $id)->first();
        if(!$student){
            return response()->json(["message"=>'Student not Found'], 404);
        }
        // Obtenha todos os dados validados
        $data = $request->validated();
        // Remova o campo 'email' dos dados antes da atualização
        unset($data['email']);
        // Atualize o aluno com os dados filtrados
        $student->update($data);
        return response()->json($student, 200);
    }

    public function validateStudentStatus(Request $request, $id)
    {
        $student = Student::where('id', $id)->first();
        if($student){
            if($student->student_status === "1"){
                return response()->json(["message" => "Student Data already Validated"], 200);
            }
            $student->student_status = 1;
            $saved = $student->save();
            if ($saved) {
                //Valide Todos os Documentos do Estudantes
                $studentDoc = StudentDocument::where('student_id', $student->id)->get();
                foreach ($studentDoc as $doc) {
                    $doc->status = 1; // Atualiza o status de cada documento
                    $doc->save(); // Salva o documento atualizado
                }
                return response()->json(["message" => "Student Data Validated"], 200);
            }
        }
        return response()->json(["message"=>"Student not found"], 404);

    }


}
