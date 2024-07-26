<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\classes;
use App\Models\course;
use App\Models\school;
use App\Models\Term;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    public function SchoolAdminViewAcademicYear(Request $request)
    {
        $schoolId = HelperFunctionsController::getUserSchoolsIds();
        $academicYear = AcademicYear::whereIn('school_id', $schoolId)
            ->join('school', 'school.id', '=', 'academic_year.school_id')
            ->select('academic_year.*', 'school.school_name')
            ->get();


        return view('dashboard.admin.academic.year.view', compact('academicYear'));
    }
    public function SchoolAdminCreateAcademicYear(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {
            $request->validate([
                'year' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'school_id' => 'required',
            ]);
            // Create new Academic Year
            $academicYear = new AcademicYear();
            $academicYear->year = $request->year;
            $academicYear->start_date = $request->start_date;
            $academicYear->end_date = $request->end_date;
            $academicYear->school_id = $request->school_id;
            $academicYear->active = $request->active === 'on' ? 1 : 0;
            $academicYear->save();
            return redirect()->route('schooladmin.academic.view')->with('success', 'Academic Year Created Successfully');
        }

        $schoolId = HelperFunctionsController::getUserSchoolsIds();

        $schools = school::whereIn('id', $schoolId)->get();

        return view('dashboard.admin.academic.year.create', compact('schools'));
    }
    public function SchoolAdminViewAcademicTerm(Request $request)
    {

        $school_id = $request->query('school_id');
        $class_id = $request->query('class_id');
        $course_id = $request->query('course_id');
        $schoolId = HelperFunctionsController::getUserSchoolsIds();
        

        if($school_id){
            session()->put('ac_school_id', $school_id);
            $classes = classes::where('school_id', $school_id)->get();
            return view('dashboard.admin.academic.term.view' , compact('classes'));
        }
        if($class_id){
            session()->put('ac_class_id', $class_id);
            $courses = course::where('school_id', session('ac_school_id'))->get();
            return view('dashboard.admin.academic.term.view' , compact('courses'));
        }
        if($course_id){
            session()->put('ac_course_id', $course_id);
            $terms = Term::where('course_id', $course_id)
            ->where('class_id', session(('ac_class_id')))
            ->get();

            $course = course::where('id', $course_id)->first();
            $class = classes::where('id', session('ac_class_id'))->first();

            session()->remove('ac_course_id');
            session()->remove('ac_class_id');
            session()->remove('ac_school_id');

            return view('dashboard.admin.academic.term.view' , compact('terms','course','class'));
        }


        $schools = school::whereIn('id', $schoolId)->get();
        return view('dashboard.admin.academic.term.view' , compact('schools'));
    }
    public function SchoolAdminCreateAcademicTerm(Request $request)
    {
        $rqMethod = $request->method();
        $school_id = $request->query('school_id');

        if($rqMethod == 'POST'){
            $request->validate([
                'title' => 'required',
                'total' => 'required',
                'course_id' => 'required',
                'class_id' => 'required',
            ]);
  
            $academicYear = new Term();
            $academicYear->title = $request->title;
            $academicYear->total = $request->total;
            $academicYear->course_id = $request->course_id;
            $academicYear->class_id = $request->class_id;
            $academicYear->save();
            return redirect()->route('schooladmin.academic.term.view')->with('success', 'Academic Year Created Successfully');
        }


        if ($school_id) {
            $courses = course::where('school_id', $school_id)->get();
            $classes = classes::where('school_id', $school_id)->get();
            return view('dashboard.admin.academic.term.create', compact('courses', 'classes'));
        }

        $schoolId = HelperFunctionsController::getUserSchoolsIds();

        $schools = school::whereIn('id', $schoolId)->get();
        #

        return view('dashboard.admin.academic.term.create', compact('schools'));
    }

}
