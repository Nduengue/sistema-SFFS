<?php

namespace App\Http\Controllers;

use App\Models\FinishQuiz;
use App\Http\Requests\StoreFinishQuizRequest;
use App\Http\Requests\UpdateFinishQuizRequest;

class FinishQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinishQuizRequest $request)
    {
        $finish = FinishQuiz::create($request->validated());

        $data = [
            "message"=>"success",
            "data"=>$finish,
        ];

        return response()->json($data);
    }
}
