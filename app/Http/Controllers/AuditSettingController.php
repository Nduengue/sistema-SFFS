<?php

namespace App\Http\Controllers;

use App\Models\AuditSetting;
use App\Http\Requests\StoreAuditSettingRequest;
use App\Models\Audit;

class AuditSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audit = AuditSetting::find(1);

        $data = [
            "data"=>$audit,
        ];

        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditSettingRequest $request)
    {   
        $audit = AuditSetting::updateOrCreate(["id"=>1], $request->validated());

        $data = [
            "message"=>"success",
        ];

        return response()->json($data);
    }
}
