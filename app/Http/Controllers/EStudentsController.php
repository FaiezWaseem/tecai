<?php

namespace App\Http\Controllers;

use App\Models\EContent;
use App\Models\EPlan;
use App\Models\EPlanPayment;
use App\Models\EStudents;
use App\Models\TContent;
use App\Models\TCourses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;



class EStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function SuperAdminViewStudents()
    {

        $students = EStudents::leftJoin('e_payment_plan', 'e_payment_plan.student_id', '=', 'e_students.id')
            ->leftJoin('e_plan', 'e_plan.id', '=', 'e_payment_plan.plan_id')
            ->select('e_students.*', 'e_plan.plan_name', 'e_payment_plan.isApproved')
            ->get();

        return view('dashboard.superadmin.ecoaching.students.view', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function SuperAdminCreateStudents(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $fullpath = $this->saveFile($file, 'web_uploads/ecoaching/students/payments/');

                $student = new EStudents;
                $student->name = $request->name;
                $student->email = $request->email;
                $student->password = $request->password;
                $student->save();

                $newPlan = new EPlanPayment;
                $newPlan->student_id = $student->id;
                $newPlan->plan_id = $request->plan_id;
                $newPlan->isApproved = ($request->isApprove === ('on' || '1')) ? true : false;
                $newPlan->start_time = now();
                $newPlan->end_time = now()->addDays(30);
                $newPlan->payment_screenshot = $fullpath;
                $newPlan->save();

                return redirect()->route('superadmin.ecoaching.students.view');
            } else {
                return 'Payment Screenshot is required';
            }
        } else {
            $Eplans = EPlan::all();
            return view('dashboard.superadmin.ecoaching.students.create', compact('Eplans'));
        }
    }

    public function EcoachingStudentLogin(Request $request)
    {
        $user = EStudents::where('email', $request->input('email'))->first();
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

    public function EcoachingStudentRegister(Request $request)
    {
        try {

            $user = EStudents::where('email', $request->input('email'))->first();
            if ($user) {
                return response()->json([
                    'message' => 'Please enter a different email address.',
                    'status' => false
                ], 200);
            }
            $student = new EStudents();
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->password = bcrypt($request->input('password'));
            $student->save();


            $newPlan = new EPlanPayment;
            $newPlan->student_id = $student->id;
            $newPlan->plan_id = $request->plan_id;
            $newPlan->isApproved = false;
            $newPlan->start_time = now();
            $newPlan->end_time = now()->addDays(30);
            $newPlan->payment_screenshot = $request->input('payment_screenshot');
            $newPlan->save();

            return response()->json([
                'success' => 'You have successfully registered.',
                'status' => true
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false
            ], 200);
        }
    }

    public function EcoachingStudentCourses(Request $request)
    {
        $stdId = $request->id;

        $courses = EPlanPayment::where('student_id', '=', $stdId)
            ->where('isApproved', 1)
            ->join('e_plan', 'e_plan.id', '=', 'e_payment_plan.plan_id')
            ->join('e_plan_course', 'e_plan_course.id', '=', 'e_plan.id')
            ->join('tcourse', 'tcourse.id', '=', 'e_plan_course.course_id')
            ->select('tcourse.*')
            ->get();

        return response()->json([
            'courses' => $courses,
            'status' => true,
        ], 200);
    }
    public function EcoachingStudentViewCourse(Request $request)
    {
        $stdId = $request->id;
        $courseId = $request->cid;

        $contents = TContent::where('tcontent.tcourse_id', $courseId)
            ->join('tchapters', 'tchapters.id', '=', 'tcontent.tchapter_id')
            ->select('tcontent.*', 'tcontent.content_title as topic_title', 'tchapters.chapter_title')
            ->get();

        return response()->json([
            'contents' => $contents,
            'status' => true,
        ], 200);
    }
    public function EcoachingStudentViewLiveClasses(Request $request)
    {
        try {
            $stdId = $request->id;
            $courses = EPlanPayment::where('student_id', '=', $stdId)
            ->where('isApproved', 1)
            ->join('e_plan', 'e_plan.id', '=', 'e_payment_plan.plan_id')
            ->join('e_plan_course', 'e_plan_course.id', '=', 'e_plan.id')
            ->join('tcourse', 'tcourse.id', '=', 'e_plan_course.course_id')
            ->select('tcourse.id')
            ->get();

            $live_sessions = EContent::where('type', 'live_session')
            ->whereIn('course_id', $courses)
            ->get()
            ;
           return response()->json([
                'live_sessions' => $live_sessions ,
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
          return  response()->json([
                'message' => $th->getMessage() ,
                'status' => false,
            ], 400);
        }

    }
    public function EcoachingStudentViewNotes(Request $request)
    {
        try {
            $stdId = $request->id;
            $courses = EPlanPayment::where('student_id', '=', $stdId)
            ->where('isApproved', 1)
            ->join('e_plan', 'e_plan.id', '=', 'e_payment_plan.plan_id')
            ->join('e_plan_course', 'e_plan_course.id', '=', 'e_plan.id')
            ->join('tcourse', 'tcourse.id', '=', 'e_plan_course.course_id')
            ->select('tcourse.id')
            ->get();

            $live_sessions = EContent::where('type', 'notes')
            ->whereIn('course_id', $courses)
            ->get()
            ;
           return response()->json([
                'notes' => $live_sessions ,
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
          return  response()->json([
                'message' => $th->getMessage() ,
                'status' => false,
            ], 400);
        }

    }
    public function EcoachingGuestCourses(Request $request)
    {
        $courses = TCourses::all();
        return response()->json([
            'courses' => $courses,
            'status' => true
        ], 200);
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
