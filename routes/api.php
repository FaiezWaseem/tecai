<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use ExpoSDK\Expo;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/student/preview/file/download/{id}', [App\Http\Controllers\PreviewFileController::class, 'ApiStudentHomeWorkPreview'])
    ->name('preview.file.download.student')
;


Route::get('/hello', function (Request $request) {

    $response = (new Expo)->send([
        [
            'title' => 'Bhai new user ka token nhi araha',
            'body' => 'kaam karna',
            'to' => 'ExponentPushToken[If6jGaG5bKaIYvfHsiByou]',
        ]
    ])->push();

    $data = $response->getData();


    return $data;
});


Route::post('/login', [App\Http\Controllers\StudentsController::class, 'login']);





Route::middleware('verify.token')->group(function () {
    
    Route::get('/user', [App\Http\Controllers\StudentsController::class, 'getStudent']);
    
    Route::get('/marks', [App\Http\Controllers\StudentsController::class, 'getStudentMarks']);

    Route::get('/assignments', [App\Http\Controllers\StudentsController::class, 'getAssignments']);

    Route::post('/user/update/token', [App\Http\Controllers\StudentsController::class, 'updateStudentToken']);

    Route::post('/grade/assignment/{id}', [App\Http\Controllers\StudentsController::class, 'studentGradeAssignment']);

    Route::get('/attendance', [App\Http\Controllers\StudentsController::class, 'getAttendance']);
    Route::post('/attendance', [App\Http\Controllers\StudentsController::class, 'getAttendanceByDate']);


    Route::get('/homeworks', [App\Http\Controllers\StudentsController::class, 'getHomeWorks']);


    Route::get('/courses', [App\Http\Controllers\TCoursesController::class, 'getCourses']);

    Route::get('/videos/live', [App\Http\Controllers\TLiveSessionsController::class, 'getLives']);
    Route::get('/videos/recorded', [App\Http\Controllers\TRecordedLecturesController::class, 'getRecorded']);
    Route::get('/timetable', [App\Http\Controllers\TtimeTableController::class, 'getSchedule']);

    Route::get('/course/content/{id}', [App\Http\Controllers\ContentController::class, 'getContent']);

});
Route::get('/assignments/{id}', [App\Http\Controllers\StudentsController::class, 'getAssignment']);

