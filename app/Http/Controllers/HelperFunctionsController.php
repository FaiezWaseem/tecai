<?php

namespace App\Http\Controllers;

use App\Models\SchoolsAdmin;
use App\Models\students;
use App\Models\teachers;
use ExpoSDK\Expo;

class HelperFunctionsController extends Controller
{
    public static function getUserSchoolsIds()
    {
        return SchoolsAdmin::where('admin_id', session('user')['id'])
            ->join('school', 'school.id', 'schools_admin.school_id')
            ->select('school.school_name', 'school.id as schoolId')
            ->pluck('schoolId');
    }
    public static function getUserSchools()
    {
        return SchoolsAdmin::where('admin_id', session('user')['id'])
            ->join('school', 'school.id', 'schools_admin.school_id')
            ->select('school.school_name', 'school.id as id')
            ->get();
    }
    public static function getUserSchoolsById($id)
    {
        return SchoolsAdmin::where('admin_id', $id)
            ->join('school', 'school.id', 'schools_admin.school_id')
            ->select('school.school_name', 'school.id as id')
            ->get();
    }
    public static function getTeacherSchoolById($id)
    {
        return teachers::find($id)->pluck('school_id')[0];
    }
    public static function sendNotification(string $to, string $title, string $body)
    {
        try {
            $response = (new Expo)->send([
                [
                    'title' => $title,
                    'body' => $body,
                    'to' => $to,
                ]
            ])->push();

            $data = $response->getData();
            return $data;
            //code...
        } catch (\Throwable $th) {
          logger($th->getMessage());
          return;
        }
    }
    public static function getCurrentStudent($id)
    {
        return students::where('id', '=', $id)->first();
    }
}
