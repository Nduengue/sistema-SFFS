<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id   =  request()->query('user_id', 0);
        $course_id =  request()->query('course_id', 0);

        if ($user_id != 0)
        $post = Post::where("user_id",$user_id)
                ->get();
        
        if ($course_id != 0)
        $post = Post::where("course_id",$course_id)
                ->get();

        if ($user_id == 0 && $course_id == 0)
        $post = Post::all();

        foreach ($post as $rows) {
            $rows->comments;
            $rows->likes;
        }
        $data =[
            "data"=>$post
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());

        $data = [
            "data"=>$post,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $data =[
            "data"=>$post
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        
        $data = [
            "data"=>$post,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        $data = [
            "data"=>$post,
            "message"=>"success"
        ];

        return response()->json($data, 200);
    }
}
