<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\students;

class AttendanceController extends Controller
{
    public function TeacherViewAttendance(Request $request)
    {

        $class_id = $request->class_id;
        $course_id = $request->course_id;

        $date = now();

        $attendance = Attendance::where('class_id', $class_id)
            ->where('course_id', $course_id)
            ->whereDate('date', '=', $date)
            ->join('students', 'attendance.student_id', '=', 'students.id')
            ->join('classes', 'attendance.class_id', '=', 'classes.id')
            ->join('course', 'attendance.course_id', '=', 'course.id')
            ->select('attendance.*', 'students.name', 'classes.class_name', 'course.course_name')
            ->get();

        return view('dashboard.teachers.attendance.view', compact('attendance', 'class_id', 'course_id'));
    }
    public function TeacherViewAttendanceByDate(Request $request)
    {
        $class_id = $request->class_id;
        $course_id = $request->course_id;
        $date = now();
        if ($request->date) {
            $date = $request->date;
        }
        $attendance = Attendance::where('class_id', $class_id)
            ->where('course_id', $course_id)
            ->whereDate('date', '=', $date)
            ->join('students', 'attendance.student_id', '=', 'students.id')
            ->join('classes', 'attendance.class_id', '=', 'classes.id')
            ->join('course', 'attendance.course_id', '=', 'course.id')
            ->select('attendance.*', 'students.name', 'classes.class_name', 'course.course_name')
            ->get();

        return view(
            'dashboard.teachers.attendance.view',
            compact(
                'attendance',
                'class_id',
                'course_id',
                'date'
            )
        );

    }
    public function TeacherCreateAttendance(Request $request)
    {

        $class_id = $request->class_id;
        $course_id = $request->course_id;

        $school_id = session('user')['school_id'];

        $students = students::where('school', $school_id)
            ->join('classes', 'students.class', '=', 'classes.class_name')
            ->where('classes.id', $class_id)
            ->select('students.*', 'classes.class_name')
            ->get();


        return view('dashboard.teachers.attendance.create', compact('class_id', 'course_id', 'students'));
    }
    public function TeacherStoreAttendance(Request $request)
    {
        $attendanceData = $request->input('attendance');

        // Process the attendance data and save it to the database
        foreach ($attendanceData as $studentId => $status) {
            // Save the attendance record for each student in the database
            Attendance::create([
                'student_id' => $studentId,
                'status' => $status,
                'class_id' => $request->class_id,
                'course_id' => $request->course_id,
                'date' => now(),
                'teacher_id' => session('user')['id'],
                'school_id' => session('user')['school_id'],
            ]);
        }

        return redirect()->route('teacher.attendances.view', [
            'class_id' => $request->class_id,
            'course_id' =>
                $request->course_id
        ]);
    }

    public function SchoolAdminViewAttendance(Request $request)
    {

        $schoolsId = HelperFunctionsController::getUserSchoolsIds();

        $date = now();

        $attendance = Attendance::whereIn('attendance.school_id', $schoolsId)
            ->whereDate('date', '=', $date)
            ->join('students', 'attendance.student_id', '=', 'students.id')

            ->select('attendance.*', 'students.name')
            ->get();

        return view('dashboard.admin.students.attendance.view', compact('attendance'));
    }
    public function SchoolAdminViewAttendanceByDate(Request $request)
    {
        $date = now();
        if ($request->date) {
            $date = $request->date;
        }
        $schoolsId = HelperFunctionsController::getUserSchoolsIds();

        $attendance = Attendance::whereIn('attendance.school_id', $schoolsId)
            ->whereDate('date', '=', $date)
            ->join('students', 'attendance.student_id', '=', 'students.id')
            ->select('attendance.*', 'students.name')
            ->get();

        return view('dashboard.admin.students.attendance.view', compact('attendance'));
    }
    public function SchoolAdminCreateAttendance(Request $request)
    {

        $schoolIds = HelperFunctionsController::getUserSchoolsIds();

        $students = students::whereIn('school', $schoolIds)
            ->join('classes', 'students.class', '=', 'classes.class_name')
            ->join('school', 'students.school', 'school.id')
            ->select('students.*', 'classes.class_name', 'school.school_name')
            ->get();


        return view('dashboard.admin.students.attendance.create', compact('students'));
    }

    public function SchoolAdminStoreAttendance(Request $request)
    {
        $attendanceData = $request->input('attendance');

        $date = now();
        if ($request->currentDate) {
            $date = $request->currentDate;
        }

        foreach ($attendanceData as $studentId => $status) {

            $std = students::find($studentId);

            $existingAttendance = Attendance::where('student_id', $studentId)
                ->whereDate('date','=', $date)
                ->count();

            if ($existingAttendance > 0) {
                continue;
            }

            Attendance::create([
                'student_id' => $studentId,
                'status' => $status,
                'date' => $date,
                'school_id' => $std->school,
            ]);
        }

        return redirect()->route('schooladmin.attendance.view');
    }

}
