<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationRequest;
use App\Models\Conversation;
use App\Rules\ConversationRule;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request, ConversationRule $conversationRule){
        if(isset($request->user_id))
        $conversation = Conversation::orWhere("user_link1",$request->user_id)
                        ->orWhere("user_link2",$request->user_id)
                        ->get();
        else
        $conversation = Conversation::where("is_group",1)
                        ->get();
        
        $data = [
            "data"=>$conversation
        ];

        return response()->json($data , 201);
    }
    public function store(StoreConversationRequest $request, ConversationRule $conversationRule){
        $request->validated();
        
        if($request->is_group==true)
        $data = [
            'name' => $request->name,
            'is_group' => $request->is_group
        ];
        else
        $data = [
            'name' => $request->name,
            'user_link1' => $request->toArray()["user_ids"][0]["user_id"],
            'user_link2' => $request->toArray()["user_ids"][1]["user_id"],
            'is_group' => $request->is_group
        ];

        $conversation = Conversation::create($data);
        if($request->is_group==true)
        $conversation->conversation_users()->createMany($request->toArray()["user_ids"]);
        $conversation->conversation_users;
        //$conversationRule->create($request->user_ids);

        return response()->json($conversation, 201);
    }
    

}
