<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\school;
use App\Models\SchoolsAdmin;
use App\Models\teachers;
use App\Models\students;
use App\Models\classes;
use App\Models\Chapter;
use App\Models\teacher_classes;
use App\Models\Attendance;
use App\Models\activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{

    // Super Admin Dashboard
    public function SuperAdminViewHome()
    {
        if (UserPermission::isSuperAdmin()) {

            // SUPER ADMIN

            $teachers = DB::table('teachers')
                ->join('school', 'teachers.school_id', '=', 'school.id')
                ->select('teachers.*', 'school.school_name')
                ->paginate(10);
            $schools = school::all();

            $students = students::take(10)->get();

            $classes = classes::all();

            $studentsCount = students::count();
            $schoolsCount = school::count();
            $teachersCount = teachers::count();
            $adminsCount = admin::count();

            return view("dashboard.superadmin.home.view")
                ->with("teachers", $teachers)
                ->with("schools", $schools)
                ->with('students', $students)
                ->with('classes', $classes)
                ->with('stats', [
                    'studentsCount' => $studentsCount,
                    'schoolsCount' => $schoolsCount,
                    'teachersCount' => $teachersCount,
                    'adminsCount' => $adminsCount,
                ]);
        }
    }
    // Super Admin View other Super Admins
    public function SuperAdminViewSuperAdmins()
    {
        if (UserPermission::isSuperAdmin()) {

            $admins = admin::where('super_admin', 1)->get();

            return view("dashboard.superadmin.admins.view")
                ->with("admins", $admins);
        }
    }
    // Super Admin View School Admins
    public function SuperAdminViewSchoolAdmins()
    {
        if (UserPermission::isSuperAdmin()) {

            $admins = DB::table('admin')
                ->join('schools_admin', 'schools_admin.admin_id', 'admin.id')
                ->join('school', 'schools_admin.school_id', '=', 'school.id')
                ->select('admin.*', 'school.school_name')
                ->paginate(10);


            return view("dashboard.superadmin.schooladmins.view")
                ->with("admins", $admins);
        }
    }
    // create a new Super Admin
    public function SuperAdminCreateSuperAdmins(Request $request)
    {
        if ($request->has('name') && $request->has('password')) {

            $admin = new admin();
            $admin->name = $request->input("name");
            $admin->super_admin = 1;
            $admin->password = bcrypt($request->input("password"));
            $admin->save();
            return redirect()->route('superadmin.admins.view');
        } else {
            return view('dashboard.superadmin.admins.create');
        }
    }
    // create a new School Admin
    public function SuperAdminCreateSchoolAdmins(Request $request)
    {
        if ($request->has('name') && $request->has('password') && $request->has('school_id')) {
            $admin = new admin();
            $admin->name = $request->input("name");
            $admin->super_admin = 0;
            $admin->password = bcrypt($request->input("password"));
            $admin->save();

            $schools = new SchoolsAdmin;
            $schools->school_id = $request->school_id;
            $schools->admin_id = $admin->id;
            $schools->save();

            return redirect()->route('superadmin.schooladmins.view');
        } else {
            $schools = school::all();
            return view('dashboard.superadmin.schooladmins.create')
                ->with('schools', $schools)
            ;
        }
    }
    public function SuperAdminDeleteSchoolAdmins(Request $request)
    {
        if ($request->id) {
            $deletedRows = admin::destroy($request->id);
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
    public function SuperAdminEditSchoolAdmins(Request $request)
    {

        if ($request->has('name')) {
            $user = admin::find($request->id);
            $user->name = $request->input("name");
            if ($request->has('password')) {
                $user->password = bcrypt($request->input("password"));
            }
            $user->save();
            return redirect()->route('superadmin.schooladmins.view');
        } else {
            $schools = school::all();
            $user = admin::find($request->id);
            $userSchools = HelperFunctionsController::getUserSchoolsById($request->id);
            return view('dashboard.superadmin.schooladmins.edit')
                ->with('schools', $schools)
                ->with('user', $user)
                ->with('userSchools', $userSchools)
            ;
        }
    }
    public function SuperAdminRemoveSchoolFromSchoolAdmin(Request $request)
    {
        $school = SchoolsAdmin::where('school_id', $request->school_id)
            ->where('admin_id', $request->id)
            ->first();
        $school->delete();
        return response()->json(['message' => 'Delete Operation Performed']);
    }
    public function SuperAdminAddSchoolToSchoolAdmin(Request $request)
    {
        $existingSchool = SchoolsAdmin::where('school_id', $request->school_id)
            ->where('admin_id', $request->id)
            ->first();

        if (!$existingSchool) {
            $school = new SchoolsAdmin;
            $school->school_id = $request->school_id;
            $school->admin_id = $request->id;
            $school->save();
            return redirect()->route('superadmin.schooladmins.view');
        } else {
            return redirect()->route('superadmin.schooladmins.view');
        }
    }

    // School Admin Dashboard
    public function SchoolAdminViewHome()
    {
        if (UserPermission::isAdmin()) {
            // SCHOOL ADMIN
            $schoolIds = HelperFunctionsController::getUserSchoolsIds();


            $classes = classes::whereIn('school_id', $schoolIds)->get();

            $outline = DB::table('outline')
                ->join('course', 'outline.course_id', '=', 'course.id')
                ->join('teachers', 'outline.teacher_id', '=', 'teachers.id')
                ->join('classes', 'outline.class_id', '=', 'classes.id')
                ->select('course.id', 'teachers.name', 'course.course_name', 'classes.class_name')
                ->whereIn('outline.school_id', $schoolIds)
                ->groupBy('course.id', 'teachers.name', 'course.course_name', 'classes.class_name')
                ->selectRaw('course.id, teachers.name, course.course_name, classes.class_name, COUNT(*) as count, COUNT(CASE WHEN outline.is_covered = 1 THEN 1 ELSE NULL END) as count_covered')
                ->get();

            $date = now();

            $attendance = Attendance::whereIn('school_id', $schoolIds)
                ->whereDate('date', '=', $date)
                ->select(
                    DB::raw('COUNT(CASE WHEN status = "present" THEN 1 END) AS total_present'),
                    DB::raw('COUNT(CASE WHEN status = "absent" THEN 1 END) AS total_absent'),
                    DB::raw('COUNT(CASE WHEN status = "late" THEN 1 END) AS total_late')
                )
                ->first();


            $studentsCount = students::whereIn('school', $schoolIds)->count();
            $studentsFemaleCount = students::whereIn('school', $schoolIds)
                ->where('gender', '=', 'female')
                ->count();
            $studentsMaleCount = students::whereIn('school', $schoolIds)
                ->where('gender', '=', 'male')
                ->count();
            $schoolsCount = count($schoolIds);
            $teachersCount = teachers::whereIn('school_id', $schoolIds)->count();
            $adminsCount = SchoolsAdmin::whereIn('school_id', $schoolIds)
                ->distinct()
                ->count();

            return view("dashboard.admin.home.view")
                ->with('classes', $classes)
                ->with('attendance', $attendance)
                ->with('stats', [
                    'studentsCount' => $studentsCount,
                    'schoolsCount' => $schoolsCount,
                    'teachersCount' => $teachersCount,
                    'adminsCount' => $adminsCount,
                    'studentsFemaleCount' => $studentsFemaleCount,
                    'studentsMaleCount' => $studentsMaleCount,
                ])
                ->with('outlines', $outline)

            ;
        }
    }

    public function TeacherViewHome()
    {
        if (UserPermission::isTeacher()) {

            $tid = session('user')['id'];

            $classes = teacher_classes::where('teacher_id', '=', $tid)
                ->count();

            $students = teacher_classes::where('teacher_id', '=', $tid)
                ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                ->join('students', 'classes.class_name', '=', 'students.class')
                ->count();

            $activities = activity::where('tid', '=', $tid)->count();

            $classesCount = teacher_classes::where('teacher_id', '=', $tid)->count();



            $chaptersCount = Chapter::where('teacher_id', '=', $tid)
                ->count();

            $studentsCount = $students = DB::table('teacher_classes')
                ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                ->join('students', function ($join) {
                    $join->on('classes.class_name', '=', 'students.class')
                        ->on('teacher_classes.school_id', '=', 'students.school');
                })
                ->where('teacher_classes.teacher_id', '=', $tid)
                ->select('students.*')
                ->count();

            $studentGenderCounts = DB::table('teacher_classes')
                ->join('classes', 'teacher_classes.class_id', '=', 'classes.id')
                ->join('students', function ($join) {
                    $join->on('classes.class_name', '=', 'students.class')
                        ->on('teacher_classes.school_id', '=', 'students.school');
                })
                ->where('teacher_classes.teacher_id', '=', $tid)
                ->select('students.gender', DB::raw('COUNT(*) as count'))
                ->groupBy('students.gender')
                ->pluck('count', 'gender')
                ->map(function ($count, $gender) {
                    return [$gender => $count];
                })
                ->values()
                ->toArray();

            return view("dashboard.teachers.home.view")
                ->with('classes', $classes)
                ->with('students', $students)
                ->with('activities', $activities)
                ->with('stats', [
                    'classesCount' => $classesCount,
                    'chaptersCount' => $chaptersCount,
                    'studentsCount' => $studentsCount,
                    'studentGenderCounts' => $studentGenderCounts,
                ])
            ;
        }
    }


    public function teacher_graph_filter(Request $request)
    {
        $teacher_id = $request->input('teacher_id');

        $outline = DB::table('outline')
            ->join('course', 'outline.course_id', '=', 'course.id')
            ->join('teachers', 'outline.teacher_id', '=', 'teachers.id')
            ->join('classes', 'outline.class_id', '=', 'classes.id')
            ->select('course.id', 'teachers.name', 'course.course_name', 'classes.class_name')
            ->where('outline.teacher_id', '=', $teacher_id)
            ->groupBy('course.id', 'teachers.name', 'course.course_name', 'classes.class_name')
            ->selectRaw('course.id, teachers.name, course.course_name, classes.class_name, COUNT(*) as count, COUNT(CASE WHEN outline.is_covered = 1 THEN 1 ELSE NULL END) as count_covered')
            ->get();
        return response()->json([
            'outline' => $outline
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $admin = new admin();
        $admin->name = $request->input("name");
        if ($request->input("school_id") === "-1" || $request->input("school_id") === -1) {
            $admin->super_admin = 1;
        } else {
            $admin->school_id = $request->input("school_id");
        }
        $admin->password = bcrypt($request->input("password"));
        $admin->save();
        return redirect()->route('index');
    }


    public function show()
    {

        $admins = DB::table('admin')
            ->join('school', 'admin.school_id', '=', 'school.id')
            ->select('admin.*', 'school.school_name')
            ->paginate(10);

        $schools = school::all();

        return view("admin.admins")
            ->with("admins", $admins)
            ->with("schools", $schools);
    }

}
