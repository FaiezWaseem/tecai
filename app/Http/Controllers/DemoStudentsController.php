<?php

namespace App\Http\Controllers;

use App\Models\Exam;

use App\Models\demostudents;
use App\Models\Tclasses;

use Illuminate\Support\Facades\Storage;

use App\Models\Term;
use DB;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Log;
use Redirect;

class DemoStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    // ==================== SCHOOL ADMIN


    // ==================== SCHOOL ADMIN


    public function SuperAdminCreateCBTSQuestionbank(Request $request)
    {
    if ($request->isMethod('POST')) {
        $dstudent = new demostudents;
        $dstudent->board_id = $request->board_id;
        $dstudent->ccourse_id = $request->class_id;
        $dstudent->cclass_id = $request->user_name;
        $dstudent->cchapter_id = $request->password;
   
            
        $dstudent->save();

        return redirect()->route('superadmin.cbts.demo.view');
    } 
    else {
        $boards = Tboards::all();
        $courses = TCourses::all();
        $classes = TClasses::all();     
        $schools = school::all();

        return view('dashboard.superadmin.cbts.demo.create')
            ->with('boards', $boards)
            ->with('classes', $classes)
            ->with('schools', $schools)
            ->with('courses', $courses);
    }
}




    public function DemoStudentViewHome(Request $request)
    {

   

        $studentId = session('user')['id'];

        $student = demostudents::where('id', $studentId)
            ->first();
        $class = Tclasses::where('class_name', $student->class)->first();
       
      ;
        $cbtsexam = Exam::where('ex_class_id', $class->id)
            ->get();

        return view('dashboard.demostudents.home.view', compact('cbtsexam'));
    }

   
}
