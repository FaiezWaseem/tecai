<?php

namespace App\Http\Controllers;
class UserPermission 
{
    public static function isSuperAdmin(){
        return session('admin') && session('user')['super_admin'] == 1;
    }
    public static function isAdmin(){
        return session('admin') && session('user')['super_admin'] == 0;
    }
    public static function isTeacher(){
        return session('isTeacher');
    }

}
