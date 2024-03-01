<?php

namespace App\Http\Controllers;

use App\Models\TClasses;
use App\Models\TCourses;
use App\Models\Ttopics;
use Illuminate\Http\Request;

class TtopicsController extends Controller
{
    public function SuperAdminViewSLO(){
        $topics = Ttopics::join('tclasses', 'tclasses.id', '=', 'ttopics.tclass_id')
        ->join('tchapters', 'tchapters.id', '=', 'ttopics.tchapter_id')
        ->join('tcourse', 'tcourse.id', '=', 'ttopics.tcourse_id')
        ->select('ttopics.*', 'tclasses.class_name', 'tchapters.chapter_title', 'tcourse.course_name')
        ->paginate(20);
        return view('dashboard.superadmin.lms.slo.view', compact('topics'));
    }
    public function SuperAdminCreateSLO(Request $request){

        $requestMethod = $request->method();
        if($requestMethod === 'POST'){
           $topic = new Ttopics();
           $topic->topic_title = $request->topic_title;
           $topic->tcourse_id = $request->tcourse_id;
           $topic->tclass_id = $request->tclass_id;
           $topic->tchapter_id = $request->tchapter_id;
           $topic->save();
           return redirect()->route('superadmin.lms.slo.view');
        }else{
            $classes= TClasses::all();
            $courses = TCourses::all();
            return view('dashboard.superadmin.lms.slo.create', compact('classes','courses'));
        }

    }
    public function SuperAdminDeleteSLO(Request $request){
        if($request->id){
            $deletedRows =  Ttopics::destroy($request->id);
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
