<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $like = Like::all();

        $data = [
            "data"=>$like
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikeRequest $request)
    {
        $like=Like::create($request->validated());
        
        $data = [
            "data"=>$like,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        $data = [
            "data"=>$like
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLikeRequest $request, Like $like)
    {
        $like->update($request->validated());

        $data = [
            "data"=>$like,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        $like->delete();
        $data = [
            "data"=>$like,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }
}
