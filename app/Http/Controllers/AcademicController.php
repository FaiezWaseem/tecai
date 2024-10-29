<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\classes;
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
    public function SchoolAdminDeleteAcademicYear(Request $request)
    {
        if ($request->id) {
            $deletedRows = AcademicYear::destroy($request->id);
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->id
            ]);
        }
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
    public function SchoolAdminEditAcademicYear(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {
            $request->validate([
                'year' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
     
            ]);
            // Create new Academic Year
            $academicYear = AcademicYear::find($request->id);
            $academicYear->year = $request->year;
            $academicYear->start_date = $request->start_date;
            $academicYear->end_date = $request->end_date;
            $academicYear->active = $request->active === 'on' ? 1 : 0;
            $academicYear->save();
            return redirect()->route('schooladmin.academic.view')->with('success', 'Academic Year Created Successfully');
        }
        $academicYear = AcademicYear::find($request->id);
        $school = school::find($academicYear->school_id);

        return view('dashboard.admin.academic.year.edit', compact('school','academicYear'));
    }
    public function SchoolAdminViewAcademicTerm(Request $request)
    {

        $school_id = $request->query('school_id');

        $schoolId = HelperFunctionsController::getUserSchoolsIds();
        

        if($school_id){
            $terms = Term::where('term.school_id', $school_id)
            ->join('classes', 'classes.id', '=', 'term.class_id')
            ->join('course', 'course.id', '=', 'term.course_id')
            ->join('school', 'school.id', '=', 'classes.school_id')

            ->select('term.*', 'classes.class_name', 'school.school_name', 'course.course_name')
            ->get();
            return view('dashboard.admin.academic.term.view' , compact('terms'));
        }
   

        $schools = school::whereIn('id', $schoolId)->get();
        return view('dashboard.admin.academic.term.view' , compact('schools'));
    }
    public function SchoolAdminCreateAcademicTerm(Request $request)
    {
        $rqMethod = $request->method();
        $school_id = $request->query('school_id');

      


        if ($school_id) {

            $classes = classes::where('school_id', $school_id)->get();
            return view('dashboard.admin.academic.term.create', compact('classes'));
        }

        $schoolId = HelperFunctionsController::getUserSchoolsIds();

        $schools = school::whereIn('id', $schoolId)->get();
        #

        return view('dashboard.admin.academic.term.create', compact('schools'));
    }
    public function SchoolAdminGetAllCoursesOfClass(Request $request)
    {
        $class_id = $request->id;
        $selectedCourses = HelperFunctionsController::getAllcoursesByClassId($class_id);
        return response()->json([
            'status' => 200,
            'courses' => $selectedCourses,
        ]);
    }
    public function SchoolAdminAddAcademicTerm(Request $request)
    {

        $school_id = $request->school_id;

            $request->validate([
                'title' => 'required',
                'total' => 'required',
            ]);
  
            $academicYear = new Term();
            $academicYear->title = $request->title;
            $academicYear->total = $request->total;
            $academicYear->school_id = $school_id;
            $academicYear->class_id = $request->class_id;
            $academicYear->course_id = $request->course_id;
            $academicYear->save();
            return response()->json([
                'status' => 200,
                'message' => 'Academic Year Created Successfully',
                'academicYear' => $academicYear,
            ]); 
   
    }

}
