<?php

namespace App\Http\Controllers;

use App\Models\GradeSetting;
use App\Http\Requests\StoreGradeSettingRequest;

class GradeSettingController extends Controller
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
    public function store(StoreGradeSettingRequest $request)
    {
        GradeSetting::where("id",1)->update($request->validated());
        return response()->json([
            "message"=>"Configuração de Nota Feita!"
        ]);

    }
}
