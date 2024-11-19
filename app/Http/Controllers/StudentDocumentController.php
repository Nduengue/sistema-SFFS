<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentDocumentRequest;
use App\Models\Student;
use App\Models\StudentDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function store(StoreStudentDocumentRequest $request)
    {
        $student = Student::where('user_id', $request->user_id)->first();
        if(!$student){
            return response()->json(["message"=>'Student not Found'], 404);
        }
        
        // Verifica se o arquivo foi enviado e é uma instância de UploadedFile
         if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            
            // Gera o nome da imagem com base no ID do usuário, data e hora atuais
            $timestamp = Carbon::now()->format('dmYHis'); // Formato: dia_mês_ano_hora_minuto_segundo
            $extension = $file->getClientOriginalExtension(); // Obtém a extensão do arquivo
            $imageName = $student->id.$timestamp . '.' . $extension; // Nome final da imagem (ID + timestamp)
            $studentDirectory = 'public/students/documents/'.$student->id;
            
            /* // Remove todas as imagens anteriores no diretório 'public/{id}/'
            if (Storage::exists($studentDirectory)) {
                Storage::deleteDirectory($studentDirectory); // Apaga o diretório inteiro, incluindo todas as imagens
            } */

            // Armazena a nova imagem no diretório 'public/{id}/'
            $imagePath = $file->storeAs($studentDirectory, $imageName);

            $doc = new StudentDocument();
            $doc->student_id = $student->id;
            $doc->doc_type = $request->doc_type;
            $doc->document = $imageName;
            $doc->emission_date = $request->emission_date;
            $doc->expiration_date = $request->expiration_date;
            $saved = $doc->save();

            // Retorna a resposta com base no resultado do salvamento
            if ($saved) {
                return response()->json(["message" => "File Uploaded"], 201);
            }

        }

        return response()->json("Error server", 500);
    }

    public function delete(Request $request, $id)
    {
        $student = Student::where('user_id', $request->user_id)->first();
        if($student){
            $studentDoc = StudentDocument::where('id', $id)->where('student_id', $student->id)->first();
            if($studentDoc->status === 1){
                return response()->json(['message' => 'Document can not be Deleted.'], 401);
            }
            if($studentDoc){
            // Caminho do documento a ser excluído
            $documentPath = 'public/students/documents/'.$student->id. '/'. $studentDoc->document;
            // Verifica se o arquivo existe antes de tentar deletar
            if (Storage::exists($documentPath)) {
                // Apaga o arquivo do sistema de arquivos
                Storage::delete($documentPath);
            } 
            // Exclui o documento do banco de dados
            $studentDoc->delete();

            return response()->json(['message' => 'Document deleted successfully.'], 200);
            }
            return response()->json(['message' => 'Document not found.'], 404);
        }
        return response()->json("Error server", 500);
    }

}
