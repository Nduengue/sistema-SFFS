<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\ClassModel;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carregar todas as classes com as relações
        $classes = ClassModel::with(['course', 'instructor', 'shift'])->get();

        // Retornar apenas os campos desejados
        $result = $classes->map(function ($class) {
            return [
                'id'   => $class->id,
                'class_name'   => $class->class_name,
                'course_name'  => $class->course->course_name,
                'course_price'  => $class->course->price,
                //'course_price_registration'  => $classes->course->price_registration,
                'instructor'   => $class->instructor->name,
                'shift_name'   => $class->shift->shift_name,
                'start_time'   => $class->shift->start_time,
                'end_time'     => $class->shift->end_time,
                'start_date'   => $class->start_date,
                'end_date'     => $class->end_date,
                'vacancies'    => $class->vacancies,
                'obs'          => $class->obs,
                'status'          => $class->status,
            ];
        });

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassRequest $request)
    {
        $classModel = ClassModel::create($request->all());
        return response()->json($classModel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Carrega a turma junto com o curso, instrutor e turno
        $classes = ClassModel::with(['course', 'instructor', 'shift'])->findOrFail($id);

        return response()->json([
            'id'           => $class->id,
            'class_name'   => $classes->class_name,
            'course_name'  => $classes->course->course_name,  
            'course_price'  => $classes->course->price,
            //'course_price_registration'  => $classes->course->price_registration,
            'instructor'   => $classes->instructor->name,    
            'shift_name'   => $classes->shift->shift_name,
            'start_time'   => $classes->shift->start_time,
            'end_time'     => $classes->shift->end_time,
            'start_date'   => $classes->start_date,
            'end_date'     => $classes->end_date,
            'vacancies'    => $classes->vacancies,
            'obs'          => $classes->obs,
            'status'          => $classes->status,
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassRequest $request, string $id)
    {
        $classModel = ClassModel::findOrFail($id);
        $classModel->update($request->all());
        return response()->json($classModel, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ClassModel::findOrFail($id)->delete();
        return response()->json(null, 200);
    }


    //Ver Cursos Disponíveis
    public function classesAvailable()
    {
        // Carregar todas as classes com as relações
        $classes = ClassModel::with(['course', 'instructor', 'shift'])
        ->where('status', 0)
        ->get();

        // Retornar apenas os campos desejados
        $result = $classes->map(function ($class) {
            return [
                'id'   => $class->id,
                'class_name'   => $class->class_name,
                'course_name'  => $class->course->course_name,
                'course_price'  => $class->course->price,
                //'course_price_registration'  => $classes->course->price_registration,
                //'instructor'   => $class->instructor->name,
                'shift_name'   => $class->shift->shift_name,
                'start_time'   => $class->shift->start_time,
                'end_time'     => $class->shift->end_time,
                'start_date'   => $class->start_date,
                'end_date'     => $class->end_date,
                //'vacancies'    => $class->vacancies,
                'obs'          => $class->obs,
                //'status'          => $class->status,
            ];
        });

        return response()->json($result, 200);
    }
}
