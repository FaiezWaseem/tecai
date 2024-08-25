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
    Route::post('/', [App\Http\Controllers\AdminController::class, 'SchoolAdminFilterCourseCoverage'])
        ->name('schooladmin.home.view');
    /**
     *  Route : SchoolAdmin / View All Classes
     *  # Display list of all Classes
     */
    Route::get('/classes/view', [App\Http\Controllers\ClassesController::class, 'SchoolAdminViewClasses'])
        ->name('schooladmin.classes.view');
    /**
     *  Route : SchoolAdmin / Create Class
     *  # Display Create Form
     */
    Route::get('/classes/create', [App\Http\Controllers\ClassesController::class, 'SchoolAdminCreateClasses'])
        ->name('schooladmin.classes.create');
    Route::post('/classes/create', [App\Http\Controllers\ClassesController::class, 'SchoolAdminCreateClasses'])
        ->name('schooladmin.classes.create');
    /**
     * Route SchoolAdmin / Delete Class
     */
    Route::delete('/classes/view/{id}', [App\Http\Controllers\ClassesController::class, 'SchoolAdminDeleteClass'])
        ->name('schooladmin.classes.delete');

    // ========================== SCHOOL CLASSES EDIT NEED TO BE IMPLEMENTED ==========================

    /**
     *  Route : SchoolAdmin / View All Courses
     *  # Display list of all Courses
     */
    Route::get('/courses/view', [App\Http\Controllers\CourseController::class, 'SchoolAdminViewCourses'])
        ->name('schooladmin.courses.view');
    /**
     *  Route : SchoolAdmin / create Course
     *  # Display create Form
     */
    Route::get('/courses/create', [App\Http\Controllers\CourseController::class, 'SchoolAdminCreateCourse'])
        ->name('schooladmin.courses.create');
    Route::post('/courses/create', [App\Http\Controllers\CourseController::class, 'SchoolAdminCreateCourse'])
        ->name('schooladmin.courses.create');
    /**
     * Route SchoolAdmin / Delete Courses
     */
    Route::delete('/courses/view/{id}', [App\Http\Controllers\CourseController::class, 'SchoolAdminDeleteCourse'])
        ->name('schooladmin.courses.delete');

    // ========================== SCHOOL COURSE EDIT NEED TO BE IMPLEMENTED ==========================

    /**
     *  Route : SchoolAdmin / View All Students
     *  # Display list of all Students
     */
    Route::get('/students/view', [App\Http\Controllers\StudentsController::class, 'SchoolAdminViewStudents'])
        ->name('schooladmin.students.view');
    Route::post('/students/view', [App\Http\Controllers\StudentsController::class, 'SchoolAdminViewStudents'])
        ->name('schooladmin.students.view');
    /**
     *  Route : SchoolAdmin / create Student
     *  # Display create Form
     */
    Route::get('/students/create', [App\Http\Controllers\StudentsController::class, 'SchoolAdminCreateStudent'])
        ->name('schooladmin.students.create');
    Route::post('/students/create', [App\Http\Controllers\StudentsController::class, 'SchoolAdminCreateStudent'])
        ->name('schooladmin.students.create');

    /**
     * Fetch Classes Record of A School For Student create
     */
    Route::post('/school/classes/', [App\Http\Controllers\StudentsController::class, 'SchoolAdminViewSchoolClasses'])
        ->name('schooladmin.school.classes.list');
    /**
     * Route SchoolAdmin / Delete Student
     */
    Route::delete('/students/view/{id}', [App\Http\Controllers\StudentsController::class, 'SchoolAdminDeleteStudent'])
        ->name('schooladmin.students.delete');
    /**
     * Route SchoolAdmin / Edit Student
     */
    Route::get('/students/{id}/edit', [App\Http\Controllers\StudentsController::class, 'SchoolAdminEditStudent'])
        ->name('schooladmin.students.edit');
    Route::put('/students/{id}/edit', [App\Http\Controllers\StudentsController::class, 'SchoolAdminEditStudent'])
        ->name('schooladmin.students.edit');


    /**
     *  Route : SchoolAdmin / View Accademic Years
     *  # Display list of all Accademic Years
     */
    Route::get('/academic/year/view', [App\Http\Controllers\AcademicController::class, 'SchoolAdminViewAcademicYear'])
        ->name('schooladmin.academic.view');
    /**
     *  Route : SchoolAdmin / Delete
     *  # Delete Acadmic Year
     */
    Route::delete('/academic/year/view/{id}', [App\Http\Controllers\AcademicController::class, 'SchoolAdminDeleteAcademicYear'])
        ->name('schooladmin.academic.delete');
    /**
     *  Route : SchoolAdmin / Edit Accademic Year
     *  # Edit Academic Year Form
     */
    Route::get('/academic/year/{id}/edit', [App\Http\Controllers\AcademicController::class, 'SchoolAdminEditAcademicYear'])
        ->name('schooladmin.academic.edit');
    Route::post('/academic/year/{id}/edit', [App\Http\Controllers\AcademicController::class, 'SchoolAdminEditAcademicYear'])
        ->name('schooladmin.academic.edit');
    /**
     *  Route : SchoolAdmin / Create Accademic Year
     *  # Create Academic Year Form
     */
    Route::get('/academic/year/create', [App\Http\Controllers\AcademicController::class, 'SchoolAdminCreateAcademicYear'])
        ->name('schooladmin.academic.create');
    Route::post('/academic/year/create', [App\Http\Controllers\AcademicController::class, 'SchoolAdminCreateAcademicYear'])
        ->name('schooladmin.academic.create');


    Route::get('/academic/term/view', [App\Http\Controllers\AcademicController::class, 'SchoolAdminViewAcademicTerm'])
        ->name('schooladmin.academic.term.view');

    Route::get('/academic/term/create', [App\Http\Controllers\AcademicController::class, 'SchoolAdminCreateAcademicTerm'])
        ->name('schooladmin.academic.term.create');
    Route::post('/academic/term/create', [App\Http\Controllers\AcademicController::class, 'SchoolAdminCreateAcademicTerm'])
        ->name('schooladmin.academic.term.create');

    /**
     *  Route : SchoolAdmin / View All Courses
     *  # Display list of all Courses
     */
    Route::get('/teachers/view', [App\Http\Controllers\TeachersController::class, 'SchoolAdminViewTeachers'])
        ->name('schooladmin.teachers.view');
    /**
     *  Route : SchoolAdmin / View Teachers Permissions
     *  # Display Permission Form
     */
    Route::get('/teachers/permissions/{id}', [App\Http\Controllers\TeachersController::class, 'SchoolAdminViewTeacherPermission'])
        ->name('schooladmin.permissions.teachers.view');
    Route::put('/teachers/permissions/{id}', [App\Http\Controllers\TeachersController::class, 'SchoolAdminViewTeacherPermission'])
        ->name('schooladmin.permissions.teachers.view');
    /**
     *  Route : SchoolAdmin / create Course
     *  # Display create Form
     */
    Route::get('/teachers/create', [App\Http\Controllers\TeachersController::class, 'SchoolAdminCreateTeachers'])
        ->name('schooladmin.teachers.create');
    Route::post('/teachers/create', [App\Http\Controllers\TeachersController::class, 'SchoolAdminCreateTeachers'])
        ->name('schooladmin.teachers.create');
    /**
     * Route SchoolAdmin / Delete Courses
     */
    Route::delete('/teachers/view/{id}', [App\Http\Controllers\TeachersController::class, 'SchoolAdminDeleteTeachers'])
        ->name('schooladmin.teachers.delete');

    Route::get('/teachers/{id}/edit', [App\Http\Controllers\TeachersController::class, 'SchoolAdminEditTeachers'])
        ->name('schooladmin.teachers.edit');
    Route::put('/teachers/{id}/edit', [App\Http\Controllers\TeachersController::class, 'put'])
        ->name('schooladmin.teachers.edit');
    Route::delete('/teachers/{id}/edit', [App\Http\Controllers\TeachersController::class, 'SchoolAdminEditDeleteTeachers'])
        ->name('schooladmin.teachers.edit');

    // ========================== SCHOOL TEACHER EDIT NEED TO BE IMPLEMENTED ==========================


    Route::get('/attendance/view', [App\Http\Controllers\AttendanceController::class, 'SchoolAdminViewAttendance'])
        ->name('schooladmin.attendance.view');
    Route::post('/attendance/view', [App\Http\Controllers\AttendanceController::class, 'SchoolAdminViewAttendanceByDate'])
        ->name('schooladmin.attendance.view');


    Route::get('/attendance/create', [App\Http\Controllers\AttendanceController::class, 'SchoolAdminCreateAttendance'])
        ->name('schooladmin.attendance.create');
    Route::post('/attendance/create', [App\Http\Controllers\AttendanceController::class, 'SchoolAdminStoreAttendance'])
        ->name('schooladmin.attendance.create');



    Route::get('/notice-board/view', [App\Http\Controllers\NoticeBoardController::class, 'SchoolAdminViewNoticeBoard'])
        ->name('schooladmin.notice.board.view');
    Route::delete('/notice-board/view/{id}', [App\Http\Controllers\NoticeBoardController::class, 'SchoolAdminDeleteNoticeBoard'])
        ->name('schooladmin.notice.board.delete');

    Route::get('/notice-board/create', [App\Http\Controllers\NoticeBoardController::class, 'SchoolAdminCreateNoticeBoard'])
        ->name('schooladmin.notice.board.create');
    Route::post('/notice-board/create', [App\Http\Controllers\NoticeBoardController::class, 'SchoolAdminCreateNoticeBoard'])
        ->name('schooladmin.notice.board.create');
});