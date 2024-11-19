<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SummaryCalendar;
use App\Http\Requests\StoreSummaryCalendarRequest;
use App\Http\Requests\UpdateSummaryCalendarRequest;

class SummaryCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SummaryCalendar = SummaryCalendar::with(['course','class', 'shift'])->get();

        // Retornar apenas os campos desejados
        $result = $SummaryCalendar->map(function ($values) {
            return [
                'id'           => $values->id,
                'course_name'   => $values->course->course_name,
                'class_name'  => $values->class->class_name,  
                'shift'   => $values->shift->shift_name .' : '.$values->shift->start_time.' - '.$values->shift->end_time,    
                'duration_months'   => $values->duration_months,
                'year'   => $values->year,
                'schedule'   => $values->schedule,
            ];
        });
       
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSummaryCalendarRequest $request)
    {
        $SummaryCalendar = SummaryCalendar::create($request->all());
        return response()->json($SummaryCalendar, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Carrega a turma junto com o curso, instrutor e turno
        $SummaryCalendar = SummaryCalendar::with(['course','class', 'shift'])->findOrFail($id);

        return response()->json([
            'id'           => $SummaryCalendar->id,
            'course_name'   => $SummaryCalendar->course->course_name,
            'class_name'  => $SummaryCalendar->class->class_name,  
            'shift'   => $SummaryCalendar->shift->shift_name .' : '.$SummaryCalendar->shift->start_time.' - '.$SummaryCalendar->shift->end_time,    
            'duration_months'   => $SummaryCalendar->duration_months,
            'year'   => $SummaryCalendar->year,
            'schedule'   => $SummaryCalendar->schedule,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSummaryCalendarRequest $request, string $id)
    {
        $SummaryCalendar = SummaryCalendar::findOrFail($id);
        $SummaryCalendar->update($request->all());
        return response()->json($SummaryCalendar, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $summaryCalendar = SummaryCalendar::findOrFail($id);
        $summaryCalendar->delete();
        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}
