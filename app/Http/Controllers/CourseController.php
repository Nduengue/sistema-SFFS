<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $query = Course::query();
        $search = $request->input('search');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search);
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$course = Course::find($id);
        $course = Course::with('courseContent')->find($id);

        if ($course) {
            //$contents = $course->courseContents; // Usar o relacionamento correto
    
            return response()->json([
                'course' => $course
                //'contents' => $course->courseContent->courseContent
            ], 200);
        }
    
        return response()->json(['message' => 'Course not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
