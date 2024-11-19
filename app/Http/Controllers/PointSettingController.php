<?php

namespace App\Http\Controllers;

use App\Models\PointSetting;
use App\Http\Requests\StorePointSettingRequest;
use App\Http\Requests\UpdatePointSettingRequest;

class PointSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PointSetting $pointSetting)
    {
        $data = [
            "data"=>$pointSetting
        ];

        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointSettingRequest $request)
    {
        PointSetting::updateOrCreate(["id"=>1],$request->validated());
    }
}
