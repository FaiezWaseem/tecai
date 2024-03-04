<?php

namespace App\Http\Controllers;

use App\Models\SchoolsAdmin;
use Illuminate\Http\Request;


class HelperFunctionsController extends Controller
{
    public static function getUserSchoolsIds(){
        return SchoolsAdmin::where('admin_id', session('user')['id'])
        ->join('school', 'school.id', 'schools_admin.school_id')
        ->select('school.school_name', 'school.id as schoolId')
        ->pluck('schoolId');
    }
    public static function getUserSchools(){
        return SchoolsAdmin::where('admin_id', session('user')['id'])
        ->join('school', 'school.id', 'schools_admin.school_id')
        ->select('school.school_name', 'school.id as id')
        ->get();
    }
    public static function getUserSchoolsById($id){
        return SchoolsAdmin::where('admin_id', $id)
        ->join('school', 'school.id', 'schools_admin.school_id')
        ->select('school.school_name', 'school.id as id')
        ->get();
    }
}
