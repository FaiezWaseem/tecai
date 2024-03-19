<?php

namespace App\Http\Controllers;

use App\Models\SchoolsAdmin;
use App\Models\students;
use ExpoSDK\Expo;

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
    public static function sendNotification(string $to , string $title , string $body ){
        $response =  (new Expo)->send([
            [
                'title' => $title,
                'body' => $body,
                'to' => $to,
            ]
        ])->push();
    
        $data = $response->getData();
        return $data;       
    }
    public static function getCurrentStudent(){
        return students::where('id', '='  ,session('user')['id'])->first();
    }
}
