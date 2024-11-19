<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Models\ItemQuestion;
use App\Models\ItemQuiz;
use App\Models\Quiz;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz = Quiz::where("course_id",request()->query("course_id",0))
                ->get();
        foreach ($quiz as $rows) {
            $rows->question;
           foreach ($rows->question as $row) {
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
    public function store(StoreResponseRequest $request)
    {
        $request->validated();
        $item =  ItemQuestion::find($request->response_id)->status;
        $response = Response::create([
            "classroom_id"=>$request->classroom_id,
            "course_id"=>$request->course_id,
            "user_id"=>$request->user_id,
            "question_id"=>$request->question_id,
            "response_id"=>$request->response_id, //ItemQuiz
            "response"=>empty($request->response)?null:$request->response,
            "status"=>$item,
        ]);
        $data = [
            'success' => true,
            "message"=>"success",
            "data"=>$response,
            "status"=>$item,
        ];

        return response()->json($data);
    }
}
