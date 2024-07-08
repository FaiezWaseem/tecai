<?php

use Illuminate\Support\Facades\Route;



/**
 *  ###################################################
 *                  STUDENTS  ROUTES
 *  ###################################################
 */
Route::middleware('CheckStudent')->prefix('/students')->group(function () {
    Route::get('/', [App\Http\Controllers\StudentsController::class, 'StudentViewHome'])
        ->name('student.home.view');
    /**
     *  Route : STUDENT / View All Assignments
     *  # Display list of all Assignment 
     */
    Route::get('/assignments/view', [App\Http\Controllers\StudentsController::class, 'StudentViewAssignments'])
        ->name('student.assignments.view');

    /**
     *  Route : Student / View All Assignments Grades
     *  # Display list of all Assignment 
     */
    Route::get('/assignments/grade/view', [App\Http\Controllers\StudentsController::class, 'StudentViewAssignmentGrades'])
        ->name('student.assignments.grade.view');

    /**
     *  Route : Teacher / View A Single Assignment
     *  # Display Preview of Assignment 
     */
    Route::get('/assignment/view/{id}', [App\Http\Controllers\TeachersController::class, 'TeacherViewAssignment'])
        ->name('student.assignment.view');


    /**
     *  Route : student / homework
     *  # Display List
     */
    Route::get('/homework/view', [App\Http\Controllers\StudentsController::class, 'StudentViewHomeWork'])
        ->name('student.homework.view');

    /**
     *  Route : Teacher / View A Single Assignment
     *  # Display Preview of Assignment 
     */
    Route::get('/content/preview/{id}', [App\Http\Controllers\TeachersController::class, 'TeacherViewFile'])
        ->name('teacher.content.preview.view');

});