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



        Route::get('/profile', [App\Http\Controllers\StudentsController::class, 'StudentViewProfile'])
        ->name('student.profile.view');
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
     *  Route : student / homework
     *  # Display List
     */
    Route::get('/reportcard/view', [App\Http\Controllers\StudentsController::class, 'StudentViewReportCard'])
        ->name('student.reportcard.view');

    /**
     *  Route : Teacher / View A Single Assignment
     *  # Display Preview of Assignment 
     */
    Route::get('/content/preview/{id}', [App\Http\Controllers\TeachersController::class, 'TeacherViewFile'])
        ->name('teacher.content.preview.view');




















        // ----------------------Student View CBTS Exam-------------------------------------




     
        Route::get('/cbts/exam/view', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSExamView'])
        ->name('student.cbts.exam.view');
        Route::get('/cbts/exam/takeexam', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSTakeExam'])
        ->name('student.cbts.exam.takeexam');
        Route::post('/cbts/exam/takeexam', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSTakeExam'])
        ->name('student.cbts.exam.takeexam');
        Route::get('/cbts/exam/startexam', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSStartExam'])
        ->name('student.cbts.exam.startexam');
        Route::post('/cbts/exam/startexam', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSStartExam'])
        ->name('student.cbts.exam.startexam');
        Route::get('/cbts/exam/result', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSResult'])
        ->name('student.cbts.exam.result');

        Route::post('/cbts/exam/examresult', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSExamResult'])
        ->name('student.cbts.exam.examresult');

        // Route to view exam results
        Route::get('/cbts/exam/examresult', [App\Http\Controllers\ExamController::class, 'StudentViewCBTSExamResult'])
            ->name('student.cbts.exam.examresult');
        
        // Route to download the exam results as a PDF
        Route::get('/cbts/exam/examresult/pdf', [App\Http\Controllers\ExamController::class, 'StudentdownloadExamResultPDF'])
            ->name('exam.results.pdf');

   

});