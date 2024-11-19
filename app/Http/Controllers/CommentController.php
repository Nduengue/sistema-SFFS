<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = request()->query('user_id', 0);
        $post_id = request()->query('post_id', 0);

        if ($user_id != 0)
        $comment = Comment::where("user_id",$user_id)
                    ->get();
        if ($post_id != 0)
        $comment = Comment::where("post_id",$post_id)
                    ->get();

        if ($user_id == 0 && $post_id == 0)
        $comment = Comment::all();
        
        foreach ($comment as $rows) {
            $rows->posts;
        }
        $data = [
            "data"=>$comment
        ];


        return response()->json($data, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment=Comment::create($request->validated());

        $data=[
            "data"=>$comment
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
       $data=[
            "data"=>$comment
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        $data=[
            "data"=>$comment
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        $data=[
            "data"=>$comment
        ];
        
        return response()->json($data, 200);
    }
}
