<?php

namespace App\Http\Controllers;
use App\Models\Tboards;
use App\Models\TClasses;
use App\Models\TCourses;
use App\Models\TContent;
use App\Models\Ttopics;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $boards = Tboards::all();
       return view('home.welcome', compact('boards'));
    }
    public function viewBoard(Request $request){
        $classes = TClasses::all();
        $board_id = $request->id;
        $board_name= $request->board_name;
        return view('home.board', compact('classes', 'board_id', 'board_name'));
    }
    public function viewClass(Request $request){
        
        $class_name= $request->class_name;
        $board_name= $request->board_name;
        $class_id= $request->class_id;
        $board_id= $request->board_id;

        $courses = TCourses::all();

        return view('home.class', compact('class_name', 'board_name', 'class_id' , 'board_id', 'courses'));

    }
    public function viewCourse(Request $request){
        
        $class_id= $request->class_id;
        $board_id= $request->board_id;
        $course_id = $request->course_id;
        $course_name = $request->course_name;

        $contents = TContent::where('tcontent.tcourse_id', $course_id)
        ->where('tcontent.tboard_id', '=', $board_id)
        ->where('tcontent.tclass_id' , $class_id)
        ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
        ->join('ttopics', 'ttopics.id', '=', 'tcontent.tslo_id')
        ->select('tcontent.*', 'ttopics.topic_title' , 'tchapters.chapter_title')
        ->get();

        $slos = Ttopics::where('tchapter_id', $course_id)->get();

        return view('home.subject', compact('contents','course_name','course_id','slos'));
    }
}
