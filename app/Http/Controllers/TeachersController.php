<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\SchoolContentPermission;
use App\Models\students;
use App\Models\tasks;
use App\Models\Tboards;
use App\Models\TClasses;
use App\Models\TCourses;
use App\Models\TeacherContent;
use App\Models\TeacherContentPermission;
use App\Models\teachers;
use App\Models\school;
use App\Models\course;
use App\Models\classes;
use App\Models\teacher_course;
use App\Models\teacher_classes;
use App\Models\activity;
use App\Models\outline;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class TeachersController extends Controller
{

    public function index()
    {
        if (UserPermission::isSuperAdmin()) {
            $teachers = DB::table('teachers')
                ->join('school', 'teachers.school_id', '=', 'school.id')
                ->select('teachers.*', 'school.school_name')
                ->paginate(10);
            $schools = school::all();
            return view("admin.teachers")
                ->with("teachers", $teachers)
                ->with("schools", $schools);
        } else {
            $teachers = DB::table('teachers')
                ->join('school', 'teachers.school_id', '=', 'school.id')
                ->select('teachers.*', 'school.school_name')
                ->where('teachers.school_id', '=', session('user')['school_id'])
                ->paginate(10);
            $coursesByTeacher = [];
            foreach ($teachers as $teacher) {
                $teacherId = $teacher->id;
                $teacherName = $teacher->name;
                $schoolName = $teacher->school_name;
                $classes = teacher_classes::where('teacher_id', '=', $teacherId)
                    ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                    ->join('course', 'teacher_classes.course_id', '=', 'course.id')
                    ->select('course.course_name', 'classes.class_name', 'teacher_classes.id')
                    ->get();

                $coursesByTeacher[] = [
                    'teacher_name' => $teacherName,
                    'school_name' => $schoolName,
                    'classes' => $classes,
                    'id' => $teacherId

                ];
            }
            return view("admin.teachers")
                ->with("teachers", $teachers)
                ->with("coursesByTeacher", $coursesByTeacher);
        }
    }
    public function SuperAdminViewTeachers()
    {
        $teachers = DB::table('teachers')
            ->join('school', 'teachers.school_id', '=', 'school.id')
            ->select('teachers.*', 'school.school_name')
            ->paginate(10);
        return view('dashboard.superadmin.teachers.view')
            ->with('teachers', $teachers)
        ;
    }
    public function SuperAdminDeleteTeachers(Request $request)
    {
        if ($request->id) {
            $deletedRows = teachers::destroy($request->id);
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
    public function SuperAdminCreateTeachers(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod === 'POST') {
            $teacher = new teachers;
            $teacher->name = $request->input("teacher_name");
            $teacher->school_id = $request->input("school_id");
            $teacher->password = bcrypt($request->input("password"));
            $teacher->save();
            return redirect()->route('superadmin.teachers.view');
        } else {
            $schools = school::all();
            return view('dashboard.superadmin.teachers.create')
                ->with('schools', $schools)
            ;
        }
    }
    public function SchoolAdminViewTeachers()
    {
        $teachers = DB::table('teachers')
            ->join('school', 'teachers.school_id', '=', 'school.id')
            ->select('teachers.*', 'school.school_name')
            ->whereIn('teachers.school_id', HelperFunctionsController::getUserSchoolsIds())
            ->paginate(10);
        $coursesByTeacher = [];
        foreach ($teachers as $teacher) {
            $teacherId = $teacher->id;
            $teacherName = $teacher->name;
            $schoolName = $teacher->school_name;
            $classes = teacher_classes::where('teacher_id', '=', $teacherId)
                ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                ->join('course', 'teacher_classes.course_id', '=', 'course.id')
                ->select('course.course_name', 'classes.class_name', 'teacher_classes.id')
                ->get();

            $coursesByTeacher[] = [
                'teacher_name' => $teacherName,
                'school_name' => $schoolName,
                'classes' => $classes,
                'id' => $teacherId

            ];
        }

        return view("dashboard.admin.teachers.view")
            ->with("teachers", $teachers)
            ->with("coursesByTeacher", $coursesByTeacher);
    }
    public function SchoolAdminCreateTeachers(Request $request)
    {
        $requestMethod = $request->method();
        if ($requestMethod === 'POST') {
            $teacher = new teachers;
            $teacher->name = $request->input("teacher_name");
            $teacher->school_id = $request->school_id;
            $teacher->password = bcrypt($request->input("password"));
            $teacher->save();
            return redirect()->route('schooladmin.teachers.view');
        } else {
            $schools = HelperFunctionsController::getUserSchools();
            return view('dashboard.admin.teachers.create')
                ->with('schools', $schools)
            ;
        }
    }
    public function SchoolAdminDeleteTeachers(Request $request)
    {
        if ($request->id) {
            $deletedRows = teachers::destroy($request->id);
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
    public function TeacherViewAssignment(Request $request, $id)
    {
        $currentUrl = url('/') . '/excercise/assets/php/create.php?id=' . $id;

        if ($request->has('student')) {
            $payload = [
                'id' => session('user')['id'],
                'email' => session('user')['email'],
            ];

            $jwt = JWT::encode($payload, 'tecai', 'HS256');
            $currentUrl = url('/') . '/excercise/assets/php/create.php?id=' . $id . '&token='.$jwt;
        }
        if ($request->has('teacher')) {
            $currentUrl = url('/') . '/excercise/assets/php/create.php?id=' . $id . '&teacher=true';
        }
        if ($request->has('token')) {
            $currentUrl = url('/') . '/excercise/assets/php/create.php?id=' . $id . '&token=' . $request->token;
        }


        $activity = activity::where('id', $id)->first();

        // Path to the public directory
        $publicPath = public_path('excercise/assets/php/');

        // Path to the JSON file within the public directory
        $filePath = $publicPath . '/data.json';

        // Write the JSON data to the file
        file_put_contents($filePath, json_encode($activity));

        return redirect($currentUrl);

    }
    public function TeacherViewAssignments()
    {
        $classes = teacher_classes::where('teacher_id', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->get();
        $courses = teacher_classes::where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id', 'course.id')
            ->get();


        $activities = activity::where('tid', '=', session('user')['id'])
            ->join('classes', 'activity.class_id', '=', 'classes.id')
            ->join('course', 'activity.course_id', '=', 'course.id')
            ->join('outline', 'activity.topic_id', '=', 'outline.id')
            ->select('classes.*', 'course.*', 'outline.*', 'outline.title as topic', 'activity.id', 'activity.title', 'activity.deadline', 'activity.created_at')
            ->paginate(5);
        return view('dashboard.teachers.assignment.view')
            ->with("activities", $activities)
            ->with("classes", $classes)
            ->with("courses", $courses);
    }
    public function TeacherViewAssignmentGrades(Request $request)
    {
        try {
            $tid = session('user')['id'];

            $activities = activity::where('tid', $tid)
                ->pluck('id')
                ->values()
                ->toArray()
            ;

            $marks = tasks::whereIn('activity_id', $activities)
                ->join('students', 'students.id', '=', 'tasks.std_id')
                ->select(
                    'tasks.id',
                    'tasks.points_obtained as obtained',
                    'tasks.points_total as total',
                    'tasks.activity_id',
                    'tasks.added_on as attempted_date',
                    'students.id as stdId',
                    'students.name as stdName',
                    'students.class as stdclass'
                )
                ->paginate(10);
            return view('dashboard.teachers.assignment.grade.view')
                ->with("marks", $marks)
            ;
            //code...
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function TeacherViewFile(Request $request, $id)
    {
        $content = TeacherContent::find($request->id);
        $content_type = $content->content_type;
        $url = Storage::disk('local')->temporaryUrl($content->content_link, now()->addMinutes(5));
        if ($content_type == 'Flash') {
            return view('home.viewer.flash', compact('content_type', 'id'));
        }
        if ($content_type == 'Pdf') {
            return view('home.viewer.pdf', compact('content_type', 'id'));
        }
        if ($content_type == 'Video') {
            return view('home.viewer.video', compact('content_type', 'id'));
        }
        if ($content_type == 'GIF') {
            return view('home.viewer.gif', compact('content_type', 'id'));
        }
        if ($content_type == 'Ppt') {
            return view('home.viewer.ppt', compact('content_type', 'id'));
        }
    }
    public function TeacherCreateAssignments(Request $request)
    {
        $topics = [];
        if ($request->input('class_id')) {

            session(['class_id' => $request->input('class_id')]);
            $courses = teacher_classes::where('teacher_classes.teacher_id', session('user')['id'])
                ->where('teacher_classes.class_id', $request->input('class_id'))
                ->join('course', 'teacher_classes.course_id', '=', 'course.id')
                ->get();

            return view('dashboard.teachers.assignment.create')
                ->with("courses", $courses)
                ->with("topics", $topics);
        }

        if ($request->input('course_id')) {
            session(['course_id' => $request->input('course_id')]);

            $topics = outline::where('outline.class_id', '=', session('class_id'))
                ->where('outline.course_id', '=', session('course_id'))
                ->join('chapter', 'chapter.id', 'outline.chapter_id')
                ->select('chapter.chapter_title', 'outline.*')
                ->get();

            return view('dashboard.teachers.assignment.create')
                ->with("topics", $topics);
        }




        $classes = teacher_classes::where('teacher_classes.school_id', '=', session('user')['school_id'])
            ->where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->select('classes.class_name', 'classes.id')
            ->distinct()
            ->get();


        return view('dashboard.teachers.assignment.create')
            ->with("classes", $classes)
            ->with("topics", $topics);
    }
    public function filter(Request $request)
    {
        $schoolId = $request->input('school');
        $teachers = DB::table('teachers')
            ->join('school', 'teachers.school_id', '=', 'school.id')
            ->select('teachers.*', 'school.school_name')
            ->where('teachers.school_id', '=', $schoolId)
            ->paginate(10);
        $schools = school::all();

        // Pass the filtered teachers to the view
        return view('admin.teachers')
            ->with("teachers", $teachers)
            ->with("schools", $schools);
    }
    public function assignmentsFilter(Request $request)
    {
        $classes = teacher_classes::where('teacher_id', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->get();
        $courses = teacher_classes::where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id', 'course.id')
            ->get();
        if ($request->input('class') != null && $request->input('course') != null) {
            $activities = activity::where('tid', '=', session('user')['id'])
                ->where('activity.class_id', '=', $request->input('class'))
                ->where('activity.course_id', '=', $request->input('course'))
                ->join('classes', 'activity.class_id', '=', 'classes.id')
                ->join('course', 'activity.course_id', '=', 'course.id')
                ->paginate(5);
            return view('dashboard.teachers.assignment.view')
                ->with("activities", $activities)
                ->with("classes", $classes)
                ->with("courses", $courses);
        }


        if ($request->input('class') != null) {
            $activities = activity::where('activity.tid', '=', session('user')['id'])
                ->where('activity.class_id', '=', $request->input('class'))
                ->join('classes', 'activity.class_id', '=', 'classes.id')
                ->join('course', 'activity.course_id', '=', 'course.id')
                ->paginate(5);
            return view('teacher.assignment')
                ->with("activities", $activities)
                ->with("classes", $classes)
                ->with("courses", $courses);
        }
        if ($request->input('course') != null) {
            $activities = activity::where('activity.tid', '=', session('user')['id'])
                ->where('activity.course_id', '=', $request->input('course'))
                ->join('classes', 'activity.class_id', '=', 'classes.id')
                ->join('course', 'activity.course_id', '=', 'course.id')
                ->paginate(5);

            return view('teacher.assignment')
                ->with("activities", $activities)
                ->with("classes", $classes)
                ->with("courses", $courses);
        }


        $activities = activity::where('tid', '=', session('user')['id'])
            ->join('classes', 'activity.class_id', '=', 'classes.id')
            ->join('course', 'activity.course_id', '=', 'course.id')
            ->paginate(5);

        return view('teacher.assignment')
            ->with("activities", $activities)
            ->with("classes", $classes)
            ->with("courses", $courses);
    }
    public function TeacherDeleteAssignments(Request $request)
    {
        if ($request->id) {
            $deletedRows = activity::destroy($request->id);
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
    public function assignments()
    {
        $classes = teacher_classes::where('teacher_id', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->get();
        $courses = teacher_classes::where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id', 'course.id')
            ->get();


        $activities = activity::where('tid', '=', session('user')['id'])
            ->join('classes', 'activity.class_id', '=', 'classes.id')
            ->join('course', 'activity.course_id', '=', 'course.id')
            ->join('outline', 'activity.topic_id', '=', 'outline.id')
            ->select('classes.*', 'course.*', 'outline.*', 'outline.title as topic', 'activity.id', 'activity.title', 'activity.deadline', 'activity.created_at')
            ->paginate(5);


        return view('teacher.assignment')
            ->with("activities", $activities)
            ->with("classes", $classes)
            ->with("courses", $courses);
    }
    public function createAssignments(Request $request)
    {
        $topics = [];
        if ($request->input('class_id')) {

            session(['class_id' => $request->input('class_id')]);
            $courses = teacher_classes::where('teacher_classes.teacher_id', session('user')['id'])
                ->where('teacher_classes.class_id', $request->input('class_id'))
                ->join('course', 'teacher_classes.course_id', '=', 'course.id')
                ->get();

            return view('teacher.createAssignment')
                ->with("courses", $courses)
                ->with("topics", $topics);
        }

        if ($request->input('course_id')) {
            session(['course_id' => $request->input('course_id')]);

            $topics = outline::where('class_id', '=', session('class_id'))
                ->where('course_id', '=', session('course_id'))
                ->get();

            return view('teacher.createAssignment')
                ->with("topics", $topics);
        }




        $classes = teacher_classes::where('teacher_classes.school_id', '=', session('user')['school_id'])
            ->where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->select('classes.class_name', 'classes.id')
            ->distinct()
            ->get();


        return view('teacher.createAssignment')
            ->with("classes", $classes)
            ->with("topics", $topics);
    }

    public function TeacherRedirectToActivity(Request $request)
    {
        session(['title' => $request->input('title')]);
        session(['total_marks' => $request->input('total_marks')]);
        session(['deadline' => $request->input('deadline')]);
        session(['topic_id' => $request->input('topic_id')]);
        return redirect($request->input('redirect'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (session('user')['super_admin'] == 1) {
            $teacher = new teachers;
            $teacher->name = $request->input("teacher_name");
            $teacher->school_id = $request->input("school_id");
            $teacher->password = bcrypt($request->input("password"));
            $teacher->save();
            return redirect()->route('teachers.show');
        } else {
            $teacher = new teachers;
            $teacher->name = $request->input("teacher_name");
            $teacher->school_id = session('user')['school_id'];
            $teacher->password = bcrypt($request->input("password"));
            $teacher->save();
            return redirect()->route('teachers.show');
        }
    }


    public function SchoolAdminViewTeacherPermission(Request $request)
    {
        $teacherId = $request->id;
        $rqMethod = $request->method();

        $teacherSchoolId = HelperFunctionsController::getTeacherSchoolById($teacherId);

        if ($rqMethod === 'PUT') {
            $isChecked = $request->isChecked === "true" ? true : false;
            $course_id = $request->courseId;
            $class_id = $request->classId;
            $board_id = $request->boardId;

            $record = TeacherContentPermission::where('teacher_id', $teacherId)
                ->where('class_id', $class_id)
                ->where('board_id', $board_id)
                ->where('course_id', $course_id)
                ->first()
            ;

            if ($record) {

                if (!$isChecked) {
                    $record->delete();
                    return response()->json([
                        'status' => true
                    ]);
                }

                return response()->json([
                    'status' => true
                ]);

            } else {


                $record = new TeacherContentPermission;
                $record->teacher_id = $teacherId;
                $record->class_id = $class_id;
                $record->course_id = $course_id;
                $record->board_id = $board_id;
                $record->save();

                return response()->json([
                    'status' => true
                ]);

            }

        }

        if ($rqMethod === 'GET') {

            $boardIds = SchoolContentPermission::where('school_id', $teacherSchoolId)
                ->pluck('board_id');

            $boards = Tboards::whereIn('id', $boardIds)->get();
            $classes = TClasses::all();
            $courses = TCourses::all();

            $permissions = TeacherContentPermission::where('teacher_id', $teacherId)
                ->get();

            return view('dashboard.admin.teachers.permissions.view', compact('boardIds', 'boards', 'classes', 'courses', 'permissions'));
        }
    }

    public function SchoolAdminEditTeachers($id)
    {
        $teacher = teachers::find($id);
        $courses = course::where('school_id', '=', $teacher->school_id)->get();
        $classes = classes::where('school_id', '=', $teacher->school_id)->get();
        $courses_id = teacher_course::where('teacher_id', $id)->pluck('course_id')->toArray();
        $classes_taken = teacher_classes::where('teacher_id', $id)->pluck('id')->toArray();

        $courses_all = teacher_classes::where('teacher_id', '=', $id)
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id')
            ->get();


        return view('dashboard.admin.teachers.edit')
            ->with("teacher", $teacher)
            ->with("courses", $courses)
            ->with("courses_id", $courses_id)
            ->with("classes", $classes)
            ->with("courses_all", $courses_all)
            ->with("classes_taken", $classes_taken);
    }
    public function SchoolAdminEditDeleteTeachers(Request $request, $id)
    {
        teacher_classes::destroy($request->input('id'));
        return response()->json([
            'deleted' => true
        ]);
    }
    public function edit($id)
    {
        $teacher = teachers::find($id);
        $courses = course::where('school_id', '=', $teacher->school_id)->get();
        $classes = classes::where('school_id', '=', $teacher->school_id)->get();
        $courses_id = teacher_course::where('teacher_id', $id)->pluck('course_id')->toArray();
        $classes_taken = teacher_classes::where('teacher_id', $id)->pluck('id')->toArray();

        $courses_all = teacher_classes::where('teacher_id', '=', $id)
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id')
            ->get();


        return view('admin.editTeacher')
            ->with("teacher", $teacher)
            ->with("courses", $courses)
            ->with("courses_id", $courses_id)
            ->with("classes", $classes)
            ->with("courses_all", $courses_all)
            ->with("classes_taken", $classes_taken);
    }


    public function put(Request $request, $id)
    {

        $courses = $request->input('subjects');
        $class = $request->input('classes');

        $teacher = teachers::find($id);


        foreach ($courses as $course) {

            // Check if the assignment already exists
            $existingAssignment = teacher_classes::where('teacher_id', $id)
                ->where('class_id', $class[0])
                ->where('course_id', $course)
                ->where('school_id', $teacher->school_id)
                ->first();

            if ($existingAssignment) {
                // Assignment already exists, handle the error or skip the course
                continue;
            }
            $teacher_class = new teacher_classes;
            $teacher_class->teacher_id = $id;
            $teacher_class->class_id = $class[0];
            $teacher_class->course_id = $course;
            $teacher_class->school_id = $teacher->school_id;
            $teacher_class->save();
        }

        $courses = teacher_classes::where('teacher_id', '=', $id)
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.id')
            ->get();

        return response()->json([
            'courses' => $courses
        ]);
    }

    public function deleteTeacherClass(Request $request, $id)
    {
        teacher_classes::destroy($request->input('id'));
        return response()->json([
            'deleted' => true
        ]);

    }



    public function TeacherViewAssignmentType($type)
    {
        if ($type == 'blanks') {
            return view('dashboard.teachers.assignment.excercise.blanks');
        }
        if ($type == 'match') {
            return view('dashboard.teachers.assignment.excercise.match');
        }
        if ($type == 'crossword') {
            return view('dashboard.teachers.assignment.excercise.crossword');
        }
        if ($type == 'parts') {
            return view('dashboard.teachers.assignment.excercise.parts');
        }
        if ($type == 'truefalse') {
            return view('dashboard.teachers.assignment.excercise.truefalse');
        }
        if ($type == 'cluegame') {
            return view('dashboard.teachers.assignment.excercise.clue');
        }

    }
    public function TeacherCreateAssignmentType(Request $request, $type)
    {

        try {

            switch ($type) {

                case 'blanks':
                case 'match':
                case 'crossword':
                case 'parts':
                case 'truefalse':
                case 'cluegame':
                    $activity = new activity;
                    $activity->tid = session('user')['id'];
                    $activity->class_id = session('class_id');
                    $activity->course_id = session('course_id');
                    $activity->total_marks = session('total_marks');
                    $activity->deadline = session('deadline');
                    $activity->topic_id = session('topic_id');
                    $activity->section_id = 1;
                    $activity->school_id = session('user')['school_id'];
                    $activity->data = $request->input('data');
                    $activity->title = session('title');
                    $activity->type = $request->input('type');
                    $activity->save();

                    $students = teacher_classes::where('teacher_id', '=', session('user')['id'])
                        ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                        ->join('students', 'classes.class_name', '=', 'students.class')
                        ->get();

                    foreach ($students as $key => $student) {
                        if ($student->token) {
                            HelperFunctionsController::sendNotification($student->token, 'New Assignment', 'Dear Student you have new Assignment Due . ' . session('title'));
                        }
                    }


                    return response()->json(['success' => true, 'message' => 'Assignment Created Successfully', 'id' => $activity->id]);
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid Type']);
            }

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
    public function TeacherViewClasses(Request $request)
    {
        $classes = teacher_classes::where('teacher_id', '=', session('user')['id'])
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
            ->join('course', 'teacher_classes.course_id', '=', 'course.id')
            ->select('course.course_name', 'classes.class_name', 'teacher_classes.class_id', 'teacher_classes.course_id')
            ->get();

        return view('dashboard.teachers.classes.view')
            ->with('classes', $classes);
    }

    public function TeacherViewOutline(Request $request)
    {

        $outline = outline::where('outline.teacher_id', '=', session('user')['id'])
            ->where('outline.school_id', '=', session('user')['school_id'])
            ->where('outline.course_id', '=', $request->route('course_id'))
            ->where('outline.class_id', '=', $request->route('class_id'))
            ->join('chapter', 'chapter.id', 'outline.chapter_id')
            ->select('outline.*', 'chapter.chapter_title')
            ->get();
        $chapters = Chapter::where('teacher_id', '=', session('user')['id'])
            ->where('school_id', '=', session('user')['school_id'])
            ->where('course_id', '=', $request->route('course_id'))
            ->where('class_id', '=', $request->route('class_id'))
            ->get();
        $course = $request->route('course_id');
        $courseName = course::where('id', '=', $course)->first();
        $class = $request->route('class_id');
        $className = classes::where('id', '=', $class)->first();

        return view('dashboard.teachers.outline.view')
            ->with('outline', $outline)
            ->with('chapters', $chapters)
            ->with('courseName', $courseName['course_name'])
            ->with('className', $className['class_name']);
    }
    public function TeacherCreateOutline(Request $request)
    {


        $classId = $request->route('class_id');
        $courseId = $request->route('course_id');
        $teacherId = session('user')['id'];
        $schoolId = session('user')['school_id'];




        if ($request->has('topic_chapter')) {

            $topic_chapter = $request->input('topic_chapter');

            $chapter = new Chapter;
            $chapter->school_id = $schoolId;
            $chapter->course_id = $courseId;
            $chapter->teacher_id = $teacherId;
            $chapter->class_id = $classId;
            $chapter->chapter_title = $topic_chapter;
            $chapter->save();

        } else if ($request->has('topic_title') && $request->has('topic_deadline')) {

            $topic_title = $request->input('topic_title');
            $topic_deadline = $request->input('topic_deadline');

            $outline = new outline;
            $outline->school_id = $schoolId;
            $outline->course_id = $courseId;
            $outline->teacher_id = $teacherId;
            $outline->class_id = $classId;
            $outline->chapter_id = $request->chapter_id;
            $outline->title = $topic_title;
            $outline->deliver_date = $topic_deadline;
            $outline->is_covered = 0;
            $outline->save();

        }
        if ($request->has('isCovered')) {
            $outline = outline::find($request->id);
            $outline->is_covered = 1;
            $outline->save();
        }


        return redirect()->route('teacher.classe.outline.show', [
            'class_id' => $classId,
            'course_id' => $courseId
        ]);
    }
    public function TeacherDeleteOutline(Request $request)
    {
        outline::destroy($request->input('id'));
        return response()->json([
            'deleted' => true
        ]);
    }
}
