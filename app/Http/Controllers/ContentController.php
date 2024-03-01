<?php

namespace App\Http\Controllers;

use App\Models\TContent;
use App\Models\Ttopics;
use Illuminate\Http\Request;
use App\Models\Tboards;
use App\Models\TCourses;
use App\Models\TClasses;
use App\Models\Tchapters;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $content = TContent::join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'tcontent.tcourse_id')
            ->select('tcontent.*', 'tclasses.class_name', 'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
            ->paginate(20);
        return view('admin.content.view', compact('content'));
    }
    public function add()
    {
        $boards = Tboards::all();
        $courses = TCourses::all();
        $classes = TClasses::all();
        return view('admin.content.add', compact('boards', 'courses', 'classes'));
    }
    public function filterChapter(Request $request)
    {
        $chapters = Tchapters::where('tcourse_id', $request->course_id)->get();
        return response()->json(['chapters' => $chapters]);
    }
    public function filterSLO(Request $request)
    {
        $slo = Ttopics::where('tchapter_id', $request->chapter_id)->get();
        return response()->json(['slo' => $slo]);
    }

    function SuperAdminViewLMSContent()
    {
        $content = TContent::join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'tcontent.tcourse_id')
            ->join('ttopics', 'ttopics.id', '=', 'tcontent.tslo_id')
            ->select('tcontent.*', 'ttopics.topic_title', 'tclasses.class_name', 'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
            ->paginate(20);
        return view('dashboard.superadmin.lms.content.view')
            ->with('content', $content)
        ;
    }
    public function SuperAdminCreateLMSContent(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod === 'POST') {
            if ($request->hasFile('content_link') && $request->hasFile('thumbnail')) {
                $file = $request->file('content_link');
                $file2 = $request->file('thumbnail');

                $fullpath = $this->saveFile($file, 'web_uploads/');
                $thumbPath = $this->saveFile($file2, 'web_uploads/thumbnail/');


                $content = new TContent;
                $content->tboard_id = $request->tboard_id;
                $content->tcourse_id = $request->tcourse_id;
                $content->tclass_id = $request->tclass_id;
                $content->tchapter_id = $request->tchapter_id;
                $content->content_type = $request->content_type;
                $content->content_link = $fullpath;
                $content->thumbnail = $thumbPath;
                $content->tslo_id = $request->tslo_id;
                $content->save();
            } else {
                return "No file selected";
            }

            return redirect()->route('superadmin.lms.content.view');
        } else {
            $boards = Tboards::all();
            $courses = TCourses::all();
            $classes = TClasses::all();
            return view('dashboard.superadmin.lms.content.create')
                ->with('boards', $boards)
                ->with('courses', $courses)
                ->with('classes', $classes)
            ;
        }
    }
    public function SuperAdminDeleteLMSContent(Request $request)
    {
        if ($request->id) {
            $deletedRows = TContent::destroy($request->id);
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
    public function SuperAdminEditLMSContent(Request $request)
    {
        // ------------------------- NEED TO IMPLEMENT
    }

    public function create(Request $request)
    {
        $content = new TContent;
        $content->tboard_id = $request->tboard_id;
        $content->tcourse_id = $request->tcourse_id;
        $content->tclass_id = $request->tclass_id;
        $content->tchapter_id = $request->tchapter_id;
        $content->topic_title = $request->topic_title;
        $content->topic_description = $request->topic_description;
        $content->content_type = $request->content_type;
        $content->content_link = $request->content_link;
        $content->save();
        return redirect()->route('admin.content.view');

    }
    public function getContent(Request $request)
    {
        $contents = TContent::where('tcontent.tcourse_id', $request->id)
            ->join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')

            ->paginate(20);
        return $contents;
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
