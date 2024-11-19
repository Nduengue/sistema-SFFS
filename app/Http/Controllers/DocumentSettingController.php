<?php

namespace App\Http\Controllers;

use App\Models\DocumentSetting;
use App\Http\Requests\StoreDocumentSettingRequest;
use Illuminate\Support\Facades\Storage;

class DocumentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentSetting = DocumentSetting::find(1);

        $data = [
            "data"=>$documentSetting
        ];
        
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentSettingRequest $request)
    {
         $request->validated();
        $file = $request->file('background_document');
        $photo = $file->store('photo', 'public');
       /*  $photo=(!empty($request->toArray()['background_document']))? Storage::disk('public')->put("photo", $request->toArray()['background_document']):DocumentSetting::find(1)->background_document;
        */ 
        $data = DocumentSetting::updateOrCreate(["id"=>1],[
            "school_name"=>$request->school_name,
            "county"=>$request->county,
            "district"=>$request->district,
            "name_director"=>$request->name_director,
            "number_school"=>$request->number_school,
            "status_school"=>$request->status_school,
            "qr_code"=>$request->qr_code,
            "background_document"=>$photo,
        ]);
 
        return response()->json([
            "message"=>"Dados do Documentos Escolar Editado Feito !",
            "data"=>$data
        ]);
    }
}
