<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Models\Commit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    /**
     * Get Message
     **/
    public function index($id)
    {
        $commit = Cache::remember('commit', 15, function () use ($id) {
            return Commit::where(["user_id"=>$id])->get();
        });
        
        $data = [
            "data"=>$commit
        ];

        return response()->json($data);
    }
    public function store(StoreNotificationRequest $request){
        $request->validated();

        $filePath = null;
        try {
            if ($request->hasFile('image')) {
                $filePath = $request->file('image')->store('uploads', 'public');
            }
        } catch (Exception $ex) {
            throw $ex->getMessage();
        }
       
        $message = Commit::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'url' => $request->url,
            'image' => $filePath
        ]);

        return response()->json($message, 201);
    }

    public function update(Request $request){
        
        Commit::where(["user_id"=>$request->user_id])->update(["view"=>false]);

    }
}
