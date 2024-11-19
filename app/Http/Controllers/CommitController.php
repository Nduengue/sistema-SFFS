<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Http\Requests\StoreCommitRequest;
use App\Http\Requests\UpdateCommitRequest;

class CommitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commit = Commit::where("view",true)
                ->where("active",true)
                ->get();

        $data = [
            "data"=>$commit
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommitRequest $request)
    {
        $data = Commit::create($request->validated());

        return response()->json([
            "message"=>"Sucesso ao Criar !",
            "status"=>$data,
            "status"=>202
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($commit)
    {
        $commit = Commit::find($commit);
        $data = [
            "data"=>$commit
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($commit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommitRequest $request,$commit)
    {
       Commit::where("id",$commit)->update($request->validated());
       return response()->json([
            "message"=>"Sucesso ao Editar !"
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commit $commit)
    {
        Commit::where("id",$commit)->update(["active"=>false]);
       return response()->json([
            "message"=>"Sucesso ao Delete !"
       ]);
    }
}
