<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\ItemQuestion;
use Illuminate\Http\UploadedFile;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz = Question::where(["active"=>true])
                ->get();
        foreach ($quiz as $rows) {
            if(!empty($rows->item))
            $rows->item;
        }
        $data = [
            "data"=>$quiz
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $request->validated();
        // Criar uma nova instância de Quiz
        $quiz = new Question();
        $quiz->quiz_id = $request->input('quiz_id');
        $quiz->question = $request->input('question');

        // Verificar se foi enviado um arquivo e lidar com o upload
        if ($request->hasFile('file')) {
            // Fazer o upload do arquivo e salvar o caminho
            $path = $request->file('file')->store('question');
            $quiz->file = $path;
        }

        // Salvar o Quiz
        $quiz->save();

        // Criar os itens do Quiz
        foreach ($request->input('items') as $itemData) {
            $item = new ItemQuestion();
            $item->question_id = $quiz->id;  // Relacionar o item ao Quiz recém-criado
            $item->response = $itemData['response'];
            $item->status = $itemData['status'] ?? false;

            // Verificar se foi enviado um arquivo para o item
            if (isset($itemData['file']) && $itemData['file'] instanceof UploadedFile) {
                $itemPath = $itemData['file']->store('quiz_items');
                $item->file = $itemPath;
            }

            // Salvar o item
            $item->save();
        }
        
        $quiz->item;
        $data = [
            "message"=>"success",
            "data"=>$quiz,
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($question)
    {
        $quiz = Question::find($question);
        if(!empty($rows->item))
            $rows->item;
        $data = [
            "data"=>$quiz
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateQuestionRequest $request, $question)
    {
        $request->validated();
        // Busque o quiz pelo id
        $quiz = Question::findOrFail($question);

        // Atualize os dados do quiz
        $quiz->quiz_id = $request->input('quiz_id');
        $quiz->question = $request->input('question');

        // Verificar se foi enviado um arquivo e lidar com o upload
        if ($request->hasFile('file')) {
            // Fazer o upload do arquivo e salvar o caminho
            $path = $request->file('file')->store('question');
            $quiz->file = $path;
        }

        // Salvar as atualizações
        $quiz->save();

        // Atualizar os itens do quiz (se houver)
        foreach ($request->input('items') as $itemData) {
            // Exemplo de como atualizar os itens
            $item = ItemQuestion::findOrFail($itemData['id']); // Supondo que cada item tenha um 'id'
            $item->response = $itemData['response'];
            $item->status = $itemData['status'] ?? false;

            // Verificar se foi enviado um arquivo para o item
            if (isset($itemData['file']) && $itemData['file'] instanceof UploadedFile) {
                $itemPath = $itemData['file']->store('quiz_items');
                $item->file = $itemPath;
            }

            // Salvar o item
            $item->save();
        }
        $data = [
            "message"=>"success"
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($question)
    {
        $quiz = Question::where("id",$question)->delete();
        
        $data = [
            "message"=>"success"
        ];

        return response()->json($data);
    }
}
