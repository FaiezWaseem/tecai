<?php

use Illuminate\Support\Facades\Route;


    /**
     *  ###################################################
     *                  SCHOOL ADMIN ROUTES
     *  ###################################################
     */
    Route::middleware('CheckSchoolAdmin')->prefix('/school_admin')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'SchoolAdminViewHome'])
        ->name('schooladmin.home.view');
    });