<?php

use Illuminate\Support\Facades\Route;

/**
 *  ###################################################
 *                  TEACHER  ROUTES
 *  ###################################################
 */
Route::middleware('CheckTeacher')->prefix('/teacher')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'TeacherViewHome'])
        ->name('teacher.home.view');
    /**
     *  Route : Teacher / View All Assignments
     *  # Display list of all Assignment 
     */
    Route::get('/assignments/view', [App\Http\Controllers\TeachersController::class, 'TeacherViewAssignments'])
        ->name('teacher.assignments.view');
    Route::delete('/assignments/view/{id}', [App\Http\Controllers\TeachersController::class, 'TeacherDeleteAssignments'])
        ->name('teacher.assignment.delete');
    /**
     *  Route : Teacher / View All filtered Assignment
     *  # Display list of all filtered Assignments 
     */
    Route::post('/assignment/filter', [App\Http\Controllers\TeachersController::class, 'assignmentsFilter'])
        ->name('teacher.assignments.show.filter.post');
    Route::get('/assignment/filter', [App\Http\Controllers\TeachersController::class, 'assignmentsFilter'])
        ->name('teacher.assignments.show.filter');
    /**
     *  Route : Teacher / View A Single Assignment
     *  # Display Preview of Assignment 
     */
    Route::get('/assignment/view/{id}', [App\Http\Controllers\TeachersController::class, 'TeacherViewAssignment'])
        ->name('teacher.assignment.view');
    /**
     *  Route : Teacher / create Assignment
     *  # Display Create view Assignment Page
     */
    Route::get('/assignments/create', [App\Http\Controllers\TeachersController::class, 'TeacherCreateAssignments'])
        ->name('teacher.assignment.create');

    Route::post('/assignments/create', [App\Http\Controllers\TeachersController::class, 'TeacherRedirectToActivity'])
        ->name('teacher.assignment.create.title');

    Route::get('/assignments/create/{type}', [App\Http\Controllers\TeachersController::class, 'TeacherViewAssignmentType'])
        ->name('teacher.assignment.create.blanks');

    Route::post('/assignments/create/{type}', [App\Http\Controllers\TeachersController::class, 'TeacherCreateAssignmentType'])
        ->name('teacher.assignment.create.blanks/post');
    /**
     *  ================ END Route : Teacher / create Assignment
     *  ================ Display Create view Assignment Page
     */


    /**
     *  Route : Teacher / Class View
     *  # Display List
     */
    Route::get('/classes/view', [App\Http\Controllers\TeachersController::class, 'TeacherViewClasses'])
        ->name('teacher.classes.view'); 
    /**
     *  Route : Teacher / Class  Course Outline View
     *  # Display List
     */
    Route::get('/{class_id}/{course_id}/outline', [App\Http\Controllers\TeachersController::class, 'TeacherViewOutline'])
        ->name('teacher.classe.outline.show');
    Route::put('/{class_id}/{course_id}/outline', [App\Http\Controllers\TeachersController::class, 'TeacherCreateOutline'])
        ->name('teacher.classe.outline.put');
    Route::delete('/{class_id}/{course_id}/outline', [App\Http\Controllers\TeachersController::class, 'TeacherDeleteOutline'])
        ->name('teacher.classe.outline.remove');

});