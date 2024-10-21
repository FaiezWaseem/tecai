<?php

namespace App\Http\Controllers;

use App\Models\TContent;
use App\Models\teacher_classes;
use App\Models\TeacherContent;
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
        $chapters = Tchapters::where('tcourse_id', $request->course_id)
        ->where('tclass_id', $request->class_id)
        ->get();
        return response()->json(['chapters' => $chapters]);
    }
    public function filterSLO(Request $request)
    {
        $slo = Ttopics::where('tchapter_id', $request->chapter_id)->get();
        return response()->json(['slo' => $slo]);
    }

    function SuperAdminViewLMSContent(Request $request)
    {

        $boards = Tboards::all();
        $classes = TClasses::all();
        $courses = TCourses::all();

        $rqMethod = $request->method();
        if ($rqMethod === 'GET') {
            $content = TContent::join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
                ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
                ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
                ->join('tcourse', 'tcourse.id', '=', 'tcontent.tcourse_id')
                ->select('tcontent.*', 'tcontent.content_title as topic_title', 'tclasses.class_name', 'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
                ->paginate(200);
            return view('dashboard.superadmin.lms.content.view')
                ->with('content', $content)
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('courses', $courses)

            ;
        } else if ($rqMethod === 'POST') {

            $content = TContent::where('tcontent.tboard_id', '=', $request->tboard_id)
                ->where('tcontent.tclass_id', '=', $request->tclass_id)
                ->where('tcontent.tcourse_id', '=', $request->tcourse_id)
                ->join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
                ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
                ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
                ->join('tcourse', 'tcourse.id', '=', 'tcontent.tcourse_id')
                ->select('tcontent.*', 'tcontent.content_title as topic_title', 'tclasses.class_name', 'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
                ->paginate(200);
            return view('dashboard.superadmin.lms.content.view')
                ->with('content', $content)
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('courses', $courses)
            ;
        }
    }
    public function SuperAdminCreateLMSContent(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod === 'POST') {
            if ($request->hasFile('thumbnail')) {
                $content_link = $request->content_link;
                $file2 = $request->file('thumbnail');

                $thumbPath = $this->saveFile($file2, 'web_uploads/thumbnail/');


                $course = TCourses::find($request->tcourse_id);
                Storage::disk('public')->makeDirectory('web_uploads/' . $course->course_name);
                Storage::disk('public')->move($content_link, 'web_uploads/' . $course->course_name . '/' . basename($content_link));

                $content_link = 'web_uploads/' . $course->course_name . '/' . basename($content_link);

                $boards = $request->input('boards');

                foreach ($boards as $board_id) {
                    $content = new TContent;
                    $content->tboard_id = $board_id;
                    $content->tcourse_id = $request->tcourse_id;
                    $content->tclass_id = $request->tclass_id;
                    $content->tchapter_id = $request->tchapter_id;
                    $content->content_type = $request->content_type;
                    $content->content_link = $content_link;
                    $content->thumbnail = $thumbPath;
                    $content->content_title = $request->content_title;
                    // $content->tslo_id = $request->tslo_id;
                    $content->save();
                }


                return redirect()->route('superadmin.lms.content.view');
            } else {
                return "No file selected";
            }


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
    public function SuperAdminDeleteBulkLMSContent(Request $request)
    {
        // Get the array of IDs from the request
        $ids = $request->ids;

        // Check if the IDs array is provided
        if (!empty($ids) && is_array($ids)) {
            // Attempt to delete the records
            $deletedRows = TContent::destroy($ids);

            // Check if any rows were deleted
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true,
                    'message' => "{$deletedRows} records deleted successfully."
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'No records were deleted. IDs might not exist.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'deleted' => false,
                'message' => 'No record IDs provided or IDs are not in the correct format.',
            ]);
        }
    }

    public function SuperAdminCopyLMSContent(Request $request)
    {
        $boards = $request->boards;
        $ids = $request->ids;

        // Validate the request
        if (empty($boards) || !is_array($boards) || empty($ids) || !is_array($ids)) {
            return response()->json([
                'status' => 400,
                'deleted' => false,
                'message' => 'No record IDs provided or IDs are not in the correct format.',
            ]);
        }

        // Fetch the content based on IDs
        $content = TContent::whereIn('id', $ids)->get();

        // Check if content exists
        if ($content->isEmpty()) {
            return response()->json([
                'status' => 404,
                'deleted' => false,
                'message' => 'No content found for the provided IDs.',
            ]);
        }

        // Copy content to specified boards
        foreach ($boards as $board) {
            foreach ($content as $item) {
                // Assuming you have a method to copy the content to the board
                $newContent = $item->replicate(); // Clone the original content
                $newContent->tboard_id = $board; // Set the new board ID
                $newContent->save(); // Save the new content
            }
        }

        return response()->json([
            'status' => 200,
            'deleted' => true,
            'message' => 'Content copied successfully.',
        ]);
    }
    public function SuperAdminEditLMSContent(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod === 'PUT') {
            if ($request->hasFile('content_link') && $request->hasFile('thumbnail')) {
                $file = $request->file('content_link');
                $file2 = $request->file('thumbnail');

                $fullpath = $this->saveFile($file, 'web_uploads/');
                $thumbPath = $this->saveFile($file2, 'web_uploads/thumbnail/');


                $content = TContent::find($request->id);
                if ($request->tboard_id) {
                    $content->tboard_id = $request->tboard_id;
                }
                if ($request->tcourse_id) {
                    $content->tcourse_id = $request->tcourse_id;
                }
                if ($request->tclass_id) {
                    $content->tclass_id = $request->tclass_id;
                }
                if ($request->tchapter_id) {
                    $content->tchapter_id = $request->tchapter_id;
                }
                if ($request->content_type) {
                    $content->content_type = $request->content_type;
                }
                $content->content_link = $fullpath;
                $content->thumbnail = $thumbPath;
                if ($request->content_title) {
                    $content->content_title = $request->content_title;
                }
                $content->save();
                return redirect()->route('superadmin.lms.content.view');
            } else {
                $content = TContent::find($request->id);
                if ($request->tboard_id) {
                    $content->tboard_id = $request->tboard_id;
                }
                if ($request->tcourse_id) {
                    $content->tcourse_id = $request->tcourse_id;
                }
                if ($request->tclass_id) {
                    $content->tclass_id = $request->tclass_id;
                }
                if ($request->tchapter_id) {
                    $content->tchapter_id = $request->tchapter_id;
                }
                if ($request->content_type) {
                    $content->content_type = $request->content_type;
                }
                if ($request->content_title) {
                    $content->content_title = $request->content_title;
                }
                $content->save();
                return redirect()->route('superadmin.lms.content.view');
            }
        } else {
            $boards = Tboards::all();
            $courses = TCourses::all();
            $classes = TClasses::all();
            $content = TContent::find($request->id);
            return view('dashboard.superadmin.lms.content.edit')
                ->with('boards', $boards)
                ->with('courses', $courses)
                ->with('classes', $classes)
                ->with('content', $content)
            ;
        }
    }


    public function TeacherViewContent(Request $request)
    {

        $tid = session('user')['id'];
        $content = TeacherContent::where('teacher_id', '=', $tid)
            ->get();

        return view('dashboard.teachers.content.view', compact('content'));
    }
    public function TeacherCreateContent(Request $request)
    {

        $tid = session('user')['id'];
        $schoolId = session('user')['school_id'];

        $requestMethod = $request->method();

        if ($requestMethod === 'POST') {
            if ($request->hasFile('content_link') && $request->hasFile('thumbnail')) {
                $file = $request->file('content_link');
                $file2 = $request->file('thumbnail');

                $fullpath = $this->saveFile($file, 'web_uploads/school_teacher_content/');
                $thumbPath = $this->saveFile($file2, 'web_uploads/school_teacher_content/thumbnail/');

                $content = new TeacherContent();
                $content->content_type = $request->content_type;
                $content->content_link = $fullpath;
                $content->teacher_id = $tid;
                $content->school_id = $schoolId;
                $content->class_id = $request->class_id;
                $content->course_id = 0;
                $content->thumbnail = $thumbPath;
                $content->save();

                return redirect()->route('teacher.content.view');

            } else {
                return 'No File Selected';
            }
        }


        $classes = teacher_classes::where('teacher_id', '=', $tid)
            ->join('classes', 'teacher_classes.class_id', 'classes.id')
            ->select('classes.*')
            ->distinct('class_name')
            ->get();

        return view('dashboard.teachers.content.create', compact('classes'));
    }
    public function TeacherDeleteContent(Request $request)
    {
        if ($request->id) {
            $deletedRows = TeacherContent::destroy($request->id);
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
        $contents = TContent::join('tboards', 'tboards.id', '=', 'tcontent.tboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'tcontent.tclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'tcontent.tcourse_id')
            ->where('tcontent.tcourse_id', $request->id)
            ->select('tcontent.*', 'tclasses.class_name', 'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
            ->get();

        return $contents;
    }
    private function saveFile($file, $path)
    {
        $filename = '';
        if ($file) {
            // Get the original filename
            $originalFilename = $file->getClientOriginalName();
            // Generate a unique filename
            $filename = uniqid() . '-' . $originalFilename . '.' . $file->getClientOriginalExtension();

            $fullPath = $path . $filename;
            Storage::disk('public')->put($fullPath, file_get_contents($file));
            return $fullPath;
        }
        return false;
    }
}
