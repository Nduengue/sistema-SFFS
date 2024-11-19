<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Http\Requests\StoreAuditRequest;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = request()->query("user_id",0);

        if($user_id!=0)
        $audit = Audit::where("user_id",$user_id)
                 ->get();
        else
        $audit = Audit::all();

        $data = [
            "data"=>$audit
        ];
        
        return response()->json($data);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditRequest $request)
    {
        $audit =  Audit::create($request->validated());
        
        $data = [
            "message"=>"success",
            "data"=>$audit
        ];
        
        return response()->json($data);

    }
}
