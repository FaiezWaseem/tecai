<?php

namespace App\Http\Controllers;

use App\Models\Tchapters;
use App\Models\TCourses;
use App\Models\TClasses;
use Illuminate\Http\Request;

class TChapterController extends Controller
{
    public function index()
    {
        $chapters = Tchapters::join('tcourse', 'tcourse.id', '=', 'tchapters.tcourse_id')
            ->join('tclasses', 'tclasses.id', '=', 'tchapters.tclass_id')
            ->select('tchapters.*', 'tcourse.course_name', 'tclasses.class_name')
            ->get();
        $courses = TCourses::all();
        $classes = TClasses::all();
        return view('admin.content.chapters.view', compact('chapters', 'courses', 'classes'));
    }
    public function SuperAdminViewLMSChapters()
    {
        $chapters = Tchapters::join('tcourse', 'tcourse.id', '=', 'tchapters.tcourse_id')
            ->join('tclasses', 'tclasses.id', '=', 'tchapters.tclass_id')
            ->select('tchapters.*', 'tcourse.course_name', 'tclasses.class_name')
            ->get();
        return view('dashboard.superadmin.lms.chapters.view', compact('chapters'));
    }
    public function SuperAdminCreateLMSChapters(Request $request){
        $requestMethod = $request->method();
        if($requestMethod == 'POST'){
            $chapter = new Tchapters();
            $chapter->chapter_title = $request->chapter_title;
            $chapter->tcourse_id = $request->tcourse_id;
            $chapter->tclass_id = $request->tclass_id;
            $chapter->save();
            return redirect()->route('superadmin.lms.chapters.view');
        }else{
            $courses = TCourses::all();
            $classes = TClasses::all();
            return view('dashboard.superadmin.lms.chapters.create', compact('courses', 'classes'));
        }
    }
    public function SuperAdminDeleteLMSChapters(Request $request){
        if($request->id){
            $deletedRows =  Tchapters::destroy($request->id);
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
            ]);
        }
    }

    public function create(Request $request)
    {
        $chapter = new Tchapters;
        $chapter->chapter_title = $request->chapter_title;
        $chapter->tcourse_id = $request->tcourse_id;
        $chapter->tclass_id = $request->tclass_id;
        $chapter->save();
        return redirect()->route('admin.content.chapters.view');
    }
    public function delete($id)
    {
        $chapter = Tchapters::find($id);
        $chapter->delete();
        return redirect()->route('admin.content.chapters.view');
    }
}
