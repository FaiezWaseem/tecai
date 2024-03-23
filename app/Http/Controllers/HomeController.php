<?php

namespace App\Http\Controllers;

use App\Models\SchoolContentPermission;
use App\Models\Tboards;
use App\Models\TClasses;
use App\Models\TCourses;
use App\Models\TContent;
use App\Models\TeacherContentPermission;
use App\Models\Ttopics;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $boards = [];
        if (!session('user')) {
            $boards = Tboards::all();
        }
        if (UserPermission::isSuperAdmin()) {
            $boards = Tboards::all();
        }
        if (UserPermission::isAdmin()) {
            $schoolsId = HelperFunctionsController::getUserSchoolsIds();
            $boards = SchoolContentPermission::whereIn('school_content_permission.school_id', $schoolsId)
                ->join('tboards', 'tboards.id', 'school_content_permission.board_id')
                ->distinct('school_content_permission.school_id')
                ->get();
        }
        if (UserPermission::isTeacher()) {
            $Id = session('user')['id'];
            $boards = TeacherContentPermission::where('teacher_content_permission.teacher_id', $Id)
                ->join('tboards', 'tboards.id', '=', 'teacher_content_permission.board_id')
                ->select('teacher_content_permission.board_id', 'tboards.*')
                ->distinct()
                ->get();
        }

        return view('home.welcome', compact('boards'));
    }
    public function viewBoard(Request $request)
    {

        $classes = [];
        $board_id = $request->id;
        $board_name = $request->board_name;

        if (!session('user')) {
            $classes = TClasses::all();
        }
        if (UserPermission::isSuperAdmin()) {
            $classes = TClasses::all();
        }
        if (UserPermission::isAdmin()) {
            $classes = TClasses::all();
        }
        if (UserPermission::isTeacher()) {
            $Id = session('user')['id'];
            $classes = TeacherContentPermission::where('teacher_content_permission.teacher_id', $Id)
                ->where('teacher_content_permission.board_id', $board_id)
                ->join('tclasses', 'tclasses.id', '=', 'teacher_content_permission.class_id')
                ->select('teacher_content_permission.class_id', 'tclasses.*')
                ->distinct()
                ->get();
        }


        return view('home.board', compact('classes', 'board_id', 'board_name'));
    }
    public function viewClass(Request $request)
    {

        $class_name = $request->class_name;
        $board_name = $request->board_name;
        $class_id = $request->class_id;
        $board_id = $request->board_id;

        $courses =[];
        
        if(!session('user')){
            $courses = TCourses::all();
        }
        if(UserPermission::isSuperAdmin()){
            $courses = TCourses::all();
        }
        if(UserPermission::isAdmin()){
            $courses = TCourses::all();
        }
        if(UserPermission::isTeacher()){
            $Id = session('user')['id'];
            $courses = TeacherContentPermission::where('teacher_content_permission.teacher_id', $Id)
            ->where('teacher_content_permission.board_id', $board_id)
            ->where('teacher_content_permission.class_id', $class_id)
            ->join('tcourse', 'tcourse.id', '=', 'teacher_content_permission.course_id')
            ->select('teacher_content_permission.class_id', 'tcourse.*')
            ->distinct()
            ->get();
        }


        return view('home.class', compact('class_name', 'board_name', 'class_id', 'board_id', 'courses'));

    }
    public function viewCourse(Request $request)
    {

        $class_id = $request->class_id;
        $board_id = $request->board_id;
        $course_id = $request->course_id;
        $course_name = $request->course_name;

        $contents = TContent::where('tcontent.tcourse_id', $course_id)
            ->where('tcontent.tboard_id', '=', $board_id)
            ->where('tcontent.tclass_id', $class_id)
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
            ->select('tcontent.*', 'tcontent.content_title as topic_title', 'tchapters.chapter_title')
            ->get();

        $slos = Ttopics::where('tchapter_id', $course_id)
            ->join('tchapters', 'tchapters.id', '=', 'ttopics.tchapter_id')
            ->get();

        return view('home.subject', compact('contents', 'course_name', 'course_id', 'slos'));
    }
}
