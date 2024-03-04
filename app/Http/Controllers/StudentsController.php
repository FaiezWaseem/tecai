<?php

namespace App\Http\Controllers;

use App\Models\students;
use App\Models\activity;
use App\Models\tasks;
use App\Models\school;
use App\Models\classes;
use App\Models\SchoolsAdmin;


use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Redirect;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolId = session('user')['school_id'];

        $students = students::where('school', $schoolId)
            ->select('students.*', 'school.school_name')
            ->paginate(50);

        $classes = classes::where('school_id', $schoolId)->get();

        return view('admin.students')
            ->with('students', $students)
            ->with('classes', $classes);

    }
    public function SuperAdminViewStudents()
    {
        $students = students::join('school', 'school.id', 'students.school')
            ->select('students.*', 'school.school_name')
            ->paginate(50);
        return view('dashboard.superadmin.students.view')
            ->with('students', $students)
        ;
    }
    public function SuperAdminCreateStudents(Request $request)
    {

        if ($request->father_name && $request->name && $request->dob && $request->email && $request->password && $request->school) {

            $student = new students();
            $student->name = $request->name;
            $student->father_name = $request->father_name;
            $student->admission_no = $request->admission_no;
            $student->group = $request->group;
            $student->email = $request->email;
            $student->password = bcrypt($request->password);
            $student->dob = $request->dob;
            $student->school = $request->school;
            $student->class = $request->class;
            $student->section = $request->section;
            $student->gender = $request->gender;
            $student->contact = $request->contact;

            $student->save();

            return redirect()->route('dashboard.superadmin.students.view');
        } else {
            $schools = school::all();
            return view('dashboard.superadmin.students.create')
                ->with('schools', $schools)
            ;
        }
    }
    public function SuperAdminEditStudent(Request $request)
    {
        $requestMethod = $request->method();

        if ($requestMethod === 'PUT') {
            $student = students::find($request->id);
            $student->name = $request->name;
            $student->father_name = $request->father_name;
            $student->admission_no = $request->admission_no;
            $student->group = $request->group;
            if ($request->email) {
                $student->email = $request->email;
            }
            if ($student->password) {
                $student->password = bcrypt($request->password);
            }
            if ($request->dob) {
                $student->dob = $request->dob;
            }
            $student->school = $request->school;
            if ($request->class) {
                $student->class = $request->class;
            }
            if ($request->section) {
                $student->section = $request->section;
            }
            if ($request->gender) {
                $student->gender = $request->gender;
            }
            if ($request->contact) {
                $student->contact = $request->contact;
            }

            $student->save();
            return redirect()->route('superadmin.students.view');
        } else if ($requestMethod === 'GET') {
            $schools = school::all();
            $student = students::find($request->id);
            return view('dashboard.superadmin.students.edit')
                ->with('schools', $schools)
                ->with('student', $student)
            ;
        } else {
            return null;
        }
    }
    public function SuperAdminDeleteStudent(Request $request)
    {
        if ($request->id) {
            $deletedRows = students::destroy($request->id);
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
    public function filter(Request $request)
    {

        $class_name = null;
        if ($request->has('class_name') && $request->input('class_name') !== null) {
            $class_name = $request->input('class_name');
            session(['filter.student.class_name' => $request->input('class_name')]);
        } else {
            $class_name = session('filter.student.class_name') ?? null;
        }

        $schoolId = session('user')['school_id'];


        $students = students::where('school', $schoolId)
            ->where('class', $class_name)
            ->paginate(50);

        $classes = classes::where('school_id', $schoolId)->get();

        return view('admin.students')
            ->with('students', $students)
            ->with('classes', $classes);
    }



    // ==================== SCHOOL ADMIN

    public function SchoolAdminViewStudents()
    {
        $schoolId = HelperFunctionsController::getUserSchoolsIds();

        $students = students::whereIn('school', $schoolId)
            ->join('school', 'school.id', 'students.school')
            ->select('students.*', 'school.school_name')
            ->paginate(50);
        return view('dashboard.admin.students.view')
            ->with('students', $students)
        ;
    }
    public function SchoolAdminDeleteStudent(Request $request)
    {
        if ($request->id) {
            $deletedRows = students::destroy($request->id);
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
    public function SchoolAdminCreateStudent(Request $request){
        if ($request->father_name && $request->name && $request->dob && $request->email && $request->password) {

            $student = new students();
            $student->name = $request->name;
            $student->father_name = $request->father_name;
            $student->admission_no = $request->admission_no;
            $student->group = $request->group;
            $student->email = $request->email;
            $student->password = bcrypt($request->password);
            $student->dob = $request->dob;
            $student->school = $request->school_id;
            $student->class = $request->class;
            $student->section = $request->section;
            $student->gender = $request->gender;
            $student->contact = $request->contact;
            $student->save();

            return redirect()->route('schooladmin.students.view');
        } else {
            $schools = HelperFunctionsController::getUserSchools();
            return view('dashboard.admin.students.create')
                ->with('schools', $schools)
            ;
        }
    }
    public function SchoolAdminEditStudent(Request $request){
        $requestMethod = $request->method();

        if ($requestMethod === 'PUT') {
            $student = students::find($request->id);
            $student->name = $request->name;
            $student->father_name = $request->father_name;
            $student->admission_no = $request->admission_no;
            $student->group = $request->group;
            if ($request->email) {
                $student->email = $request->email;
            }
            if ($student->password) {
                $student->password = bcrypt($request->password);
            }
            if ($request->dob) {
                $student->dob = $request->dob;
            }
            if ($request->class) {
                $student->class = $request->class;
            }
            if ($request->section) {
                $student->section = $request->section;
            }
            if ($request->gender) {
                $student->gender = $request->gender;
            }
            if ($request->contact) {
                $student->contact = $request->contact;
            }

            $student->save();
            return redirect()->route('schooladmin.students.view');
        } else if ($requestMethod === 'GET') {
            $schools = school::all();
            $student = students::find($request->id);
            return view('dashboard.admin.students.edit')
                ->with('schools', $schools)
                ->with('student', $student)
            ;
        } else {
            return null;
        }
    }
    // ==================== SCHOOL ADMIN



    public function login(Request $request)
    {


        $user = students::where('email', $request->input('email'))->first();
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'email' => 'The provided credentials do not match our records.',
            ], 200);
        }
        $payload = [
            'id' => $user->id,
            'email' => $user->email,
        ];

        $jwt = JWT::encode($payload, 'tecai', 'HS256');

        return response()->json([
            'success' => 'You have successfully logged in.',
            'user' => $user,
            'token' => $jwt,
        ], 200);
    }
    public function getStudent(Request $request)
    {
        $student = students::where('id', $request->id)->first();
        return response()->json([
            'success' => 'You have successfully logged in.',
            'user' => $student,
        ], 200);
    }
    public function getAssignments(Request $request)
    {
        $student = students::where('students.id', $request->id)
            ->join('school', 'students.school', '=', 'school.id')
            ->first();
        $class = classes::where('class_name', $student->class)->first();
        $activity = activity::where('class_id', $class->id)
            ->join('course', 'activity.course_id', '=', 'course.id')
            ->join('teachers', 'activity.tid', '=', 'teachers.id')
            ->select('activity.*', 'teachers.name as teacher_name')
            ->get();

        return response()->json([
            'success' => true,
            'assignments' => $activity,
            'class' => $class,
            'student' => $student,
            'class_id' => $class->id,
            'class_name' => $class->class_name,
        ]);
    }
    public function getAssignment(Request $request, $id)
    {
        $currentUrl = url('/') . '/excercise/assets/php/create.php?id=' . $id;

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

    public function studentGradeAssignment(Request $request, $id)
    {

        if (!$request->has('points_obtained')) {
            return response()->json([
                'success' => false,
                'message' => 'Please Provide points_obtained field'
            ]);
        }
        if (!$request->has('points_total')) {
            return response()->json([
                'success' => false,
                'message' => 'Please Provide points_total field'
            ]);
        }


        $tasks = new tasks();
        $tasks->std_id = $request->id;
        $tasks->activity_id = $id;
        $tasks->points_obtained = $request->points_obtained;
        $tasks->points_total = $request->points_total;
        $tasks->save();
        return response()->json([
            'success' => true,
            'task' => $tasks
        ]);
    }


}
