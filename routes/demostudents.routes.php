<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;




/**
 *  ###################################################
 *                  STUDENTS  ROUTES
 *  ###################################################
 */
Route::middleware('CheckDemoStudent')->prefix('/demostudents')->group(function () {
    Route::get('/', [App\Http\Controllers\DemoStudentsController::class, 'DemoStudentViewHome'])
        ->name('demostudent.home.view');
    
        Route::get('/cbts/exam/view', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSExamView'])
        ->name('demostudent.cbts.exam.view');
       
       
        Route::get('/cbts/exam/takeexam', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSTakeExam'])
        ->name('demostudent.cbts.exam.takeexam');
        Route::post('/cbts/exam/takeexam', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSTakeExam'])
        ->name('demostudent.cbts.exam.takeexam');
       
       
        Route::get('/cbts/exam/startexam', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSStartExam'])
        ->name('demostudent.cbts.exam.startexam');
        
        Route::post('/cbts/exam/startexam', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSStartExam'])
        ->name('demostudent.cbts.exam.startexam');
        Route::get('/cbts/exam/result', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSResult'])
        ->name('demostudent.cbts.exam.result');

        Route::post('/cbts/exam/examresult', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSExamResult'])
        ->name('demostudent.cbts.exam.examresult');

        // Route to view exam results
        Route::get('/cbts/exam/examresult', [App\Http\Controllers\ExamController::class, 'DemoStudentViewCBTSExamResult'])
            ->name('demostudent.cbts.exam.examresult');
        
        // Route to download the exam results as a PDF
        Route::get('/cbts/exam/examresult/pdf', [ExamController::class, 'DemoStudentdownloadExamResultPDF'])
            ->name('demostudents.cbts.exam.results.pdf');

        
});

