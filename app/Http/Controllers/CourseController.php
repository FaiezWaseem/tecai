<?php

namespace App\Http\Controllers;

use App\Models\course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = DB::table('course')
        ->join('school', 'course.school_id', '=','school.id')
        ->select('course.*','school.school_name')
        ->where('course.school_id', '=', session('user')['school_id'])
        ->paginate(50);
        return view("admin.courses")->with("courses", $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session('user')['school_id']){
            $course = new course;
            $course->course_name = $request->input("course_name");
            $course->school_id = session('user')['school_id'];
            $course->save();
            return redirect()->route('courses.show');
        }else{
            return redirect()->route('courses.show')->with('error', 'You are not authorized to perform this action!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $courseId = $request->input('id');
        if($courseId){
            $course = Course::find($courseId);
            $course->delete();
            return redirect()->route('courses.show');
        }
    }
}
