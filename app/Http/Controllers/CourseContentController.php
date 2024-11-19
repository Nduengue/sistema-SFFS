<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\Course;
use App\Http\Requests\StoreCourseContentRequest;
use App\Http\Requests\UpdateCourseContentRequest;

class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contents = CourseContent::with(['course'])->get();
        // Retornar apenas os campos desejados
        $result = $contents->map(function ($values) {
            return [
                'id'           => $values->id,
                'course_name'   => $values->course->course_name,
                'contents' => $values->contents
            ];
        });
       
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseContentRequest $request)
    {
        $content = CourseContent::create($request->all());
        return response()->json($content, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contents = CourseContent::with(['course'])->findOrFail($id);
        return response()->json([
            'id'           => $contents->id,
            'course_name'   => $contents->course->course_name,
            'contents' => $contents->contents
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseContentRequest $request, string $id)
    {
        $content = CourseContent::findOrFail($id);
        $content->update($request->all());
        return response()->json($content, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(string $id)
    {
        CourseContent::findOrFail($id)->delete();
        return response()->json(null, 204);
    } */
}
