<?php

namespace App\Http\Controllers;

use App\Models\HomeWork;
use App\Models\teacher_classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeWorkController extends Controller
{
    public function TeacherViewHomeWork(Request $request)
    {

        $tid = session('user')['id'];
        $content = HomeWork::where('teacher_id','=', $tid)
        ->get();

        return view('dashboard.teachers.homework.view', compact('content'));
    }
    public function TeacherCreateHomeWork(Request $request)
    {

        $tid = session('user')['id'];
        $schoolId = session('user')['school_id'];

        $requestMethod = $request->method();

        if ($requestMethod === 'POST') {
            if ($request->hasFile('thumbnail')) {
                $file2 = $request->file('thumbnail');

                $thumbPath = $this->saveFile($file2, 'web_uploads/school_teacher_content/homework/');

                $content = new HomeWork();

                $content->teacher_id = $tid;
                $content->school_id = $schoolId;
                $content->class_id = $request->class_id;
                $content->content = $request->content;
                $content->date = $request->date;
                $content->image = $thumbPath;
                $content->save();

                $students = teacher_classes::where('teacher_id', '=', session('user')['id'])
                    ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                    ->join('students', 'classes.class_name', '=', 'students.class')
                    ->get();

                  foreach ($students as $key => $student) {
                    if($student->token){
                        HelperFunctionsController::sendNotification($student->token , 'New Assignment' , 'Dear Student you have new Assignment Due . '.session('title'));
                    }
                  }  
                
                return redirect()->route('teacher.homework.view');

            } else {
                $content = new HomeWork();
                
                $content->teacher_id = $tid;
                $content->school_id = $schoolId;
                $content->class_id = $request->class_id;
                $content->date = $request->date;
                $content->content = $request->content;
                $content->image = null;
                $content->save();

                $students = teacher_classes::where('teacher_id', '=', session('user')['id'])
                    ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                    ->join('students', 'classes.class_name', '=', 'students.class')
                    ->get();

                  foreach ($students as $key => $student) {
                    if($student->token){
                        HelperFunctionsController::sendNotification($student->token , 'New Assignment' , 'Dear Student you have new Assignment Due . '.session('title'));
                    }
                  }  

                return redirect()->route('teacher.homework.view');

            }
        }


        $classes = teacher_classes::where('teacher_id', '=', $tid)
            ->join('classes', 'teacher_classes.class_id', 'classes.id')
            ->select('classes.*')
            ->distinct('class_name')
            ->get();

        return view('dashboard.teachers.homework.create', compact('classes'));
    }
    public function TeacherDeleteHomeWork(Request $request){
        if ($request->id) {
            $deletedRows = HomeWork::destroy($request->id);
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
    private function saveFile($file, $path)
    {
        $filename = '';
        if ($file) {
            // Get the original filename
            $originalFilename = $file->getClientOriginalName();
            // Generate a unique filename
            $filename = uniqid(). '-' . $originalFilename . '.' . $file->getClientOriginalExtension();

            $fullPath = $path . $filename;
            Storage::disk('public')->put( $fullPath, file_get_contents($file));
            return $fullPath;
        }
        return false;
    }
}
