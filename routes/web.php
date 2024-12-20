<?php

use Illuminate\Support\Facades\Route;





Route::get('/docs/api' , function(){
    return view('docs.api');
});


Route::get('/fileupload', [App\Http\Controllers\LargeFileUploadController::class, 'uploadLargeFiles'])
    ->name('upload.large.file');
Route::post('/fileupload', [App\Http\Controllers\LargeFileUploadController::class, 'uploadLargeFiles'])
    ->name('upload.large.file');


Route::get('/teacher/preview/file/{id}', [App\Http\Controllers\PreviewFileController::class, 'TeacherViewFile'])
    ->name('teacher.preview.file');
Route::get('/preview/file/download/{id}', [App\Http\Controllers\PreviewFileController::class, 'downloadFile'])
    ->name('preview.file.download');

    Route::get('/preview/file/{id}', [App\Http\Controllers\PreviewFileController::class, 'index'])
        ->name('preview.file');

Route::get('/ecoaching/thumbnail/preview/' , [App\Http\Controllers\EStudentsController::class, 'EcoachingViewthumbnail']);





Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])
    ->name('auth.login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticateUser']);


Route::middleware('auth')->group(function () {
    require_once __DIR__ . '/home.routes.php';

    Route::get('/school_logo', [App\Http\Controllers\AuthController::class, 'getSchoolLogo'])
    ->name('school.logo');
    ;
    Route::get('/school_banner', [App\Http\Controllers\AuthController::class, 'getSchoolBanner'])
    ->name('school.banner');
    ;

});

// Auth only routes
Route::middleware('auth')->prefix('/dashboard')->group(function () {





    /**
     *  ###################################################
     *                  HOME ROUTES
     *  ###################################################
     */

    Route::get('/board/{board_id}/{class_id}/{course_id}/{board_name}/{class_name}/{course_name}', [App\Http\Controllers\HomeController::class, 'viewCourse'])
        ->name('home.board.course');

    /**
     *  ###################################################
     *                  SUPER ADMIN ROUTES
     *  ###################################################
     */
    require_once __DIR__ . '/superadmin.routes.php';


    /**
     *  ###################################################
     *                  SCHOOL ADMIN ROUTES
     *  ###################################################
     */
    require_once __DIR__ . '/schooladmin.routes.php';


    /**
     *  ###################################################
     *                  TEACHER  ROUTES
     *  ###################################################
     */
    require_once __DIR__ . '/teachers.routes.php';


    /**
     *  ###################################################
     *                  STUDENT  ROUTES
     *  ###################################################
     */
    require_once __DIR__ . '/students.routes.php';
    /**
     *  ###################################################
     *                 DEMO STUDENT  ROUTES
     *  ###################################################
     */
    require_once __DIR__ . '/demostudents.routes.php';



    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])
        ->name('auth.logout');

    /**
     *  ##############################################################
     *   OLD  ROUTES NEED TO BE REMOVED ONCE ALL ARE RE-IMPLEMENTED
     *  ##############################################################
     */







    // Tution Timetable
    Route::get('/content/schedule', [App\Http\Controllers\TtimeTableController::class, 'index'])
        ->name('admin.content.schedule.view')
        ->middleware('CheckSuperAdmin');
    Route::post('/content/schedule', [App\Http\Controllers\TtimeTableController::class, 'create'])
        ->name('admin.content.schedule.create')
        ->middleware('CheckSuperAdmin');

    // Tution Live Sessions
    Route::get('/content/livesessions', [App\Http\Controllers\TLiveSessionsController::class, 'index'])
        ->name('admin.content.livesessions.view')
        ->middleware('CheckSuperAdmin');
    Route::post('/content/livesessions', [App\Http\Controllers\TLiveSessionsController::class, 'create'])
        ->name('admin.content.livesessions.create')
        ->middleware('CheckSuperAdmin');

    // Tution Recorded Lectures
    Route::get('/content/record/lectures', [App\Http\Controllers\TRecordedLecturesController::class, 'index'])
        ->name('admin.content.recordlectures.view')
        ->middleware('CheckSuperAdmin');
    Route::post('/content/record/lectures', [App\Http\Controllers\TRecordedLecturesController::class, 'create'])
        ->name('admin.content.recordlectures.create')
        ->middleware('CheckSuperAdmin');




    Route::post('/admin/teacher/graph/filter', [App\Http\Controllers\AdminController::class, 'teacher_graph_filter'])
        ->name('admin.teacher.graph.filter');

    Route::post('/teachers/filter', [App\Http\Controllers\TeachersController::class, 'filter'])
        ->name('teachers.filter');

    Route::get('/students/filter', [App\Http\Controllers\StudentsController::class, 'filter'])
        ->name('students.filter');

    Route::post('/students/filter', [App\Http\Controllers\StudentsController::class, 'filter'])
        ->name('students.filter.post');


});