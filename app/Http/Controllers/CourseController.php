<?php

namespace App\Http\Controllers;

use App\Models\course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function SchoolAdminViewCourses(){
        $courses = DB::table('course')
        ->join('school', 'course.school_id', '=','school.id')
        ->select('course.*','school.school_name')
        ->where('course.school_id', '=', session('user')['school_id'])
        ->get();
        return view("dashboard.admin.courses.view")->with("courses", $courses);
    }
    public function SchoolAdminCreateCourse(Request $request){
        $requestMethod = $request->method();
        if($requestMethod === 'POST'){
            $course = new course;
            $course->course_name = $request->input("course_name");
            $course->school_id = session('user')['school_id'];
            $course->save();
            return redirect()->route('schooladmin.courses.view');
        }else{
            return view('dashboard.admin.courses.create');
        }
    }
    public function SchoolAdminDeleteCourse(Request $request){
        if($request->id){
            $deletedRows =  course::destroy($request->id);
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        }else{
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->id
            ]);
        }
    }

}
