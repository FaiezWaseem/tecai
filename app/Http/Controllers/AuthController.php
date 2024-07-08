<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\students;
use App\Models\teachers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(UserPermission::isSuperAdmin()){
            return redirect()->route('superadmin.home.view');
        }else if(UserPermission::isAdmin()){
            return redirect()->route('schooladmin.home.view');
        }elseif(UserPermission::isTeacher()){
            return redirect()->route('teacher.home.view');
    
        }elseif(UserPermission::isStudent()){
            return redirect()->route('student.home.view');
        } 
        else {
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
                $user = students::where('email', $request->name)->first();
                if (!$user || !\Hash::check($request->password, $user->password)) {
                    return back()->withErrors([
                        'email' => "The provided  credentials do not match our records.",
                    ]);
                }
            }
          
        }
        
        session(['user' => $user, 'admin' => $isAdmin, 'isTeacher' => $isTeacher , 'isStudent' => $isStudent]);

        if(UserPermission::isSuperAdmin()){
            return redirect()->route('superadmin.home.view');
        }else if(UserPermission::isAdmin()){
            return redirect()->route('schooladmin.home.view');
        }else if(UserPermission::isTeacher()){
            return redirect()->route('teacher.home.view');
        }else if (UserPermission::isStudent()){
            return redirect()->route('student.home.view');
        }else{
            return redirect()->route('auth.login');
        }
        

    }

    public function logout(){
        session()->flush();
        return redirect()->route('auth.login');
    }
}

