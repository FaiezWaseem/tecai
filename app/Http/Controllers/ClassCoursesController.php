<?php

namespace App\Http\Controllers;

use App\Models\ClassCourses;
use Illuminate\Http\Request;

class ClassCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classId = $request->id;
        $courseId = $request->courseId;
        $isChecked = $request->isChecked;

        $classCourse = ClassCourses::where('class_id', $classId)
        ->where('course_id', $courseId)
        ->first();

        /**
         * If course is Checked and Course is not in the class
         * then add the course to the class
         */
        if( $isChecked && !$classCourse ){
            $classCourse = new ClassCourses;
            $classCourse->class_id = $classId;
            $classCourse->course_id = $courseId;
            $classCourse->save();
            return response()->json([
                'status' => 200,
                'message' => 'Course Added to Class',
                'classCourse' => $classCourse
            ]);
        }
        /**
         * If course is not Checked and Course is in the class
         * then remove the course from the class
         */
        if( !!$isChecked && $classCourse->exists() ){
            $classCourse->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Course Removed from Class',
                'classCourse' => $classCourse
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Course Not Added to Class',
            'classCourse' => $classCourse,
            'isChecked' => $isChecked,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassCourses $classCourses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassCourses $classCourses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassCourses $classCourses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassCourses $classCourses)
    {
        //
    }
}
