<?php

namespace App\Http\Controllers;

use App\Models\ClassCourses;
use App\Models\classes;
use App\Models\course;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    public function SchoolAdminViewClasses(){
        $classes = classes::whereIn('school_id', HelperFunctionsController::getUserSchoolsIds())
        ->join('school', 'classes.school_id', '=','school.id')
        ->select('classes.*','school.school_name')
        ->get();
        return view('dashboard.admin.classes.view')
        ->with('classes', $classes);
    }
    public function SchoolAdminDeleteClass(Request $request){
        if($request->id){
            $deletedRows =  classes::destroy($request->id);
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
    public function SchoolAdminCreateClasses(Request $request){
        $requestMethod = $request->method();
        if($requestMethod === 'POST'){
            $request->validate([
                'class_name' =>'required|string|max:255',
            ]);
            $class = new classes;
            $class->class_name = $request->class_name;
            $class->school_id = $request->school_id;
            $class->save();
            return redirect()->route('schooladmin.classes.view');
        }else{
            $schools = HelperFunctionsController::getUserSchools();
            return view('dashboard.admin.classes.create' , compact('schools'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' =>'required|string|max:255',
        ]);
        $class = new classes;
        $class->class_name = $request->class_name;
        $class->school_id = session('user')['school_id'];
        $class->save();
        return redirect()->route('classes.show');
    }

    public function SchoolAdminEditClass(Request $request){

        $class_id = $request->id;
        $class = classes::find($class_id);

        $courses = course::where('school_id' , $class->school_id)->get();

        $selectedCourses = ClassCourses::where('class_id', $class_id)->get();

        return view('dashboard.admin.classes.edit' , compact('courses' , 'class' ,'selectedCourses'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        classes::destroy($request->input('id'));
        $classes = classes::where('school_id', session('user')['school_id'])->get();
        return view('admin.classes')
        ->with('classes', $classes);
    }
}
