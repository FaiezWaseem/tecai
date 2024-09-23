<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\school;
use App\Models\students;
use App\Models\teachers;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (UserPermission::isSuperAdmin()) {
            return redirect()->route('superadmin.home.view');
        } else if (UserPermission::isAdmin()) {
            return redirect()->route('schooladmin.home.view');
        } elseif (UserPermission::isTeacher()) {
            return redirect()->route('teacher.home.view');

        } elseif (UserPermission::isStudent()) {
            return redirect()->route('student.home.view');
        } else {
            return view('auth.login');
        }

    }


    public function authenticateUser(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required|string',
        ], [
            'name.required' => 'The name field is required.',
            'password.required' => 'The password field is required.',
        ]);


        $user = admin::where('name', $request->name)->first();
        $isAdmin = true;
        $isTeacher = false;
        $isStudent = false;
        if (!$user || !\Hash::check($request->password, $user->password)) {
            $user = teachers::where('name', $request->name)->first();
            $isAdmin = false;
            $isTeacher = true;
            if (!$user || !\Hash::check($request->password, $user->password)) {
                $isAdmin = false;
                $isTeacher = false;
                $isStudent = true;

                $prefix_school = $request->name;

                // Split the string by underscore
                $parts = explode('_', $prefix_school);

                // Get the first part as the prefix
                $prefix = $parts[0];
                $admission_no = $parts[1];

                $school = school::where('prefix', $prefix)->first();
                $user = students::where('admission_no', $admission_no)
                    ->where('school', $school->id)
                    ->first();
                if (!$user || !\Hash::check($request->password, $user->password)) {
                    return back()->withErrors([
                        'email' => "No User Found, Please Check Your Password",
                    ]);
                }
            }

        }

        session(['user' => $user, 'admin' => $isAdmin, 'isTeacher' => $isTeacher, 'isStudent' => $isStudent]);

        if (UserPermission::isSuperAdmin()) {
            return redirect()->route('superadmin.home.view');
        } else if (UserPermission::isAdmin()) {
            return redirect()->route('schooladmin.home.view');
        } else if (UserPermission::isTeacher()) {
            return redirect()->route('teacher.home.view');
        } else if (UserPermission::isStudent()) {
            return redirect()->route('student.home.view');
        } else {
            return redirect()->route('auth.login');
        }


    }

    public function getSchoolLogo()
    {
        if (UserPermission::isAdmin()) {
            $schoolIds = HelperFunctionsController::getUserSchoolsIds();
            if ($schoolIds->count() > 0) {
                $schoolId = $schoolIds[0];
                $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->logo;
                $filePath = Storage::disk('local')->path($schoolLogo);
                $fileName = 'out.png';
                $headers = [
                    'Content-Type' => 'image/png',
                ];
                return Response::download($filePath, $fileName, $headers);
            }
            return response()->json(['schoolIds' => $schoolIds]);
        } else if (UserPermission::isTeacher()) {
            $schoolId = HelperFunctionsController::getTeacherSchoolById(session('user')['id']);
            $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->logo;
            $filePath = Storage::disk('local')->path($schoolLogo);
            $fileName = 'out.png';
            $headers = [
                'Content-Type' => 'image/png',
            ];
            return Response::download($filePath, $fileName, $headers);
        } else if (UserPermission::isStudent()) {
            $schoolId = HelperFunctionsController::getUserSchoolsById(session('user')['id']);
            $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->logo;
            $filePath = Storage::disk('local')->path($schoolLogo);
            $fileName = 'out.png';
            $headers = [
                'Content-Type' => 'image/png',
            ];
            return Response::download($filePath, $fileName, $headers);
        } else {
            $filePath = public_path('images/tec.png'); // Use public_path to get the correct file path
            $fileName = 'out.png'; // Desired name for the downloaded file
            $headers = [
                'Content-Type' => 'image/png',
            ];
        
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }
        
            return Response::download($filePath, $fileName, $headers);
        }
    }
    public function getSchoolBanner()
    {
        if (UserPermission::isAdmin()) {
            $schoolIds = HelperFunctionsController::getUserSchoolsIds();
            if ($schoolIds->count() > 0) {
                $schoolId = $schoolIds[0];
                $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->banner;
                $filePath = Storage::disk('local')->path($schoolLogo);
                $fileName = 'out.png';
                $headers = [
                    'Content-Type' => 'image/png',
                ];
                return Response::download($filePath, $fileName, $headers);
            }
            return response()->json(['schoolIds' => $schoolIds]);
        } else if (UserPermission::isTeacher()) {
            $schoolId = HelperFunctionsController::getTeacherSchoolById(session('user')['id']);
            $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->banner;
            $filePath = Storage::disk('local')->path($schoolLogo);
            $fileName = 'out.png';
            $headers = [
                'Content-Type' => 'image/png',
            ];
            return Response::download($filePath, $fileName, $headers);
        } else if (UserPermission::isStudent()) {
            $schoolId = HelperFunctionsController::getUserSchoolsById(session('user')['id']);
            $schoolLogo = \App\Models\school::where('id', $schoolId)->first()->banner;
            $filePath = Storage::disk('local')->path($schoolLogo);
            $fileName = 'out.png';
            $headers = [
                'Content-Type' => 'image/png',
            ];
            return Response::download($filePath, $fileName, $headers);
        } else {
            $filePath = public_path('bg.jpg'); // Use public_path to get the correct file path
            $fileName = 'out.png'; // Desired name for the downloaded file
            $headers = [
                'Content-Type' => 'image/png',
            ];
        
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }
        
            return Response::download($filePath, $fileName, $headers);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.login');
    }
}

