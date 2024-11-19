<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Get Message
     **/
    public function index($id)
    {
        $message = Message::where(["conversation_id"=>$id])->get();

        $data = [
            "data"=>$message
        ];

        return response()->json($data);
    }
    public function store(StoreMessageRequest $request){
        $request->validated();

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
            'file_path' => $filePath
        ]);

        return response()->json($message, 201);
    }

}
