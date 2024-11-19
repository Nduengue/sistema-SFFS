<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\ItemQuiz;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz = Quiz::where(["active"=>true])
                ->get();

        foreach ($quiz as $rows) {
            if (!empty($rows->question)) 
            $rows->question;
            foreach ($rows->question as $row) {
                if (!empty($row->item)) 
                $row->item;
            }
        }
        $data = [
            "data"=>$quiz
        ];

        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $quiz =  Quiz::create($request->validated());
        
        $data = [
            "message"=>"success",
            "data"=>$quiz
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($quiz)
    {
        $quiz = Quiz::find($quiz);
        $quiz->question; 
        foreach ($quiz->question as $row) {
            $row->item;
        }
        $data = [
            "data"=>$quiz
        ];

        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, $quiz)
    {
        $quiz =  Quiz::where("id",$quiz)->update($request->validated());
        
        $data = [
            "message"=>"success",
            "data"=>$quiz
        ];

        return response()->json($data);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($quiz)
    {
        $quiz = Quiz::where("id",$quiz)->delete();
        
        $data = [
            "message"=>"success"
        ];

        return response()->json($data);
    }
}
