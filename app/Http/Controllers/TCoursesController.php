<?php

namespace App\Http\Controllers;

use App\Models\TCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TCoursesController extends Controller
{
    public function index()
    {
        $courses = TCourses::all();
        return view('admin.content.subject.view', compact('courses'));
    }

    public function SuperAdminViewLMSSubjects()
    {
        $courses = TCourses::all();
        return view('dashboard.superadmin.lms.subjects.view', compact('courses'));
    }
    public function SuperAdminCreateLMSSubjects(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod == 'POST') {
            $filename = '';
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                // Generate a unique filename
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // Store the file in the public disk
                Storage::disk('public')->put($filename, file_get_contents($file));
                $courses = new TCourses();
                $courses->course_name = $request->course_name;
                $courses->thumbnail = $filename;
                $courses->save();
                return redirect()->route('superadmin.lms.subjects.view');
            } else {
                echo "No File";
            }
        } else {
            return view('dashboard.superadmin.lms.subjects.create');
        }
    }
    public function SuperAdminEditLMSSubjects(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod == 'PUT') {
            $filename = '';
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                // Generate a unique filename
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                // Store the file in the public disk
                Storage::disk('public')->put($filename, file_get_contents($file));
            }
            $courses =TCourses::find($request->id);
            $courses->course_name = $request->course_name;
            if ($filename !== '') {
                $courses->thumbnail = $filename;
            }
            $courses->save();
            return redirect()->route('superadmin.lms.subjects.view');
        } else {
            $course = TCourses::find($request->id);
            return view('dashboard.superadmin.lms.subjects.edit', compact('course'));
        }

    }
    public function SuperAdminDeleteLMSSubjects(Request $request)
    {
        if ($request->id) {
            $deletedRows = TCourses::destroy($request->id);
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
            ]);
        }
    }

    public function create(Request $request)
    {
        $subjects = new TCourses();
        $subjects->course_name = $request->course_name;
        $subjects->save();
        return redirect()->route('admin.content.subject.view');
    }
    public function getCourses()
    {
        return TCourses::Paginate(50);
    }
}
