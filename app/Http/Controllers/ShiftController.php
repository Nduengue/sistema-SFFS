<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::all();
        return response()->json($shifts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShiftRequest $request)
    {
        $shifts = Shift::create($request->all());
        return response()->json($shifts, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shifts = Shift::findOrFail($id);
        return response()->json($shifts, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShiftRequest $request, string $id)
    {
        $shifts = Shift::findOrFail($id);
        $shifts->update($request->all());
        return response()->json($shifts, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Shift::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
