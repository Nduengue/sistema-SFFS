<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Http\Requests\StoreUploadRequest;
use App\Http\Requests\UpdateUploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->query("course_id",0)==0)
        $uploads = Upload::all();
        else
        $uploads = Upload::where("course_id",request()->query("course_id",0))->get();
        foreach ($uploads as $rows) {
            $rows->url = url("storage/$rows->file_path"); 
        }
       return response()->json(["data"=>$uploads]);
    }
    /**
     * Display a listing of the resource.
     */
    public function report()
    {
        $uploads = Upload::where('course_id',request()->query("course_id",0))
        ->selectRaw('file_type, COUNT(*) as count')
        ->groupBy('file_type')
        ->get();

       return response()->json(["data"=>$uploads]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUploadRequest $request)
    {
        $request->validated();
    
        $file = $request->file('file');
        $filePath = $file->store('uploads', 'public');
    
        Upload::create([
            'file_path' => $filePath,
            'file_type' => $file->getClientMimeType(),
            'course_id' => $request->course_id,
            'name' => $request->name,
        ]);
    
        return response()->json(['message' => 'Upload realizado com sucesso']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Upload $upload)
    {
        return response()->json(["data"=>$upload]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUploadRequest $request, Upload $upload)
    {
        $request->validated();
    
        if ($request->hasFile('file')) {
            // Excluir o arquivo antigo, se necessário
            if ($upload->file_path) 
            Storage::disk('public')->delete($upload->file_path);
    
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $upload->file_path = $filePath;
            $upload->file_type = $file->getClientMimeType();
        }
    
        $upload->course_id = $request->course_id;
        $upload->save();
    
        return response()->json(['message' => 'Upload realizado com sucesso']);
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Upload $upload)
    {
        // Excluir o arquivo do storage
        if ($upload->file_path) {
            Storage::disk('public')->delete($upload->file_path);
        }

        $upload->delete();
        return response()->json(['message' => 'Upload excluído com sucesso']);
    }
}
