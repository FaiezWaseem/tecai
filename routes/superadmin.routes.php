<?php

use Illuminate\Support\Facades\Route;


    /**
     *  ###################################################
     *                  SUPER ADMIN ROUTES
     *  ###################################################
     */



Route::middleware('CheckSuperAdmin')->prefix('/superadmin')->group(function () {
    
    /**
     * Route : SuperAdmin  Dashboard
     *  # Displays all the Summary or Schools , Students , Admins  
     */
    Route::get('/', [App\Http\Controllers\AdminController::class, 'SuperAdminViewHome'])
    ->name('superadmin.home.view');
    /**
     *  Route : SuperAdmin / View SuperAdmins 
     *  # Display list of all other super admins 
     */
    Route::get('/admins/view', [App\Http\Controllers\AdminController::class, 'SuperAdminViewSuperAdmins'])
    ->name('superadmin.admins.view');
    /**
     *  Route : SuperAdmin / create SuperAdmin
     *  # Super Admin Create More Super Admins , Inshort a Super Admin create Form
     */
    Route::get('/admins/create', [App\Http\Controllers\AdminController::class, 'SuperAdminCreateSuperAdmins'])
    ->name('superadmin.admins.create');
    Route::post('/admins/create', [App\Http\Controllers\AdminController::class, 'SuperAdminCreateSuperAdmins'])
    ->name('superadmin.admins.post');
    /**
     *  Route : SuperAdmin / View School Admins 
     *  # Display list of all school admins and their school name
     */
    Route::get('/admins/school/view', [App\Http\Controllers\AdminController::class, 'SuperAdminViewSchoolAdmins'])
    ->name('superadmin.schooladmins.view');
    /**
     * Route SuperAdmin / Delete School Admin
     */
    Route::delete('/admins/school/view/{id}', [App\Http\Controllers\AdminController::class, 'SuperAdminDeleteSchoolAdmins'])
    ->name('superadmin.schooladmins.delete');
    /**
     *  Route : SuperAdmin / Create School Admin
     * # Super Admin Create More School Admins , Inshort a ceate School Admin create Form
     */
    Route::get('/admins/school/create', [App\Http\Controllers\AdminController::class, 'SuperAdminCreateSchoolAdmins'])
    ->name('superadmin.schooladmins.create');
    Route::post('/admins/school/create', [App\Http\Controllers\AdminController::class, 'SuperAdminCreateSchoolAdmins'])
    ->name('superadmin.schooladmins.post');

    /**
     *  Route Admin / update School Admin
     *  # Display Update Form and Update Record
     */
    Route::get('/admins/school/{id}/edit', [App\Http\Controllers\AdminController::class, 'SuperAdminEditSchoolAdmins'])
    ->name('superadmin.schooladmins.edit');
    Route::put('/admins/school/{id}/edit', [App\Http\Controllers\AdminController::class, 'SuperAdminEditSchoolAdmins'])
    ->name('superadmin.schooladmins.edit');
    Route::delete('/admins/school/{id}/edit', [App\Http\Controllers\AdminController::class, 'SuperAdminRemoveSchoolFromSchoolAdmin'])
    ->name('superadmin.schooladmins.edit');
    Route::post('/admins/school/{id}/edit', [App\Http\Controllers\AdminController::class, 'SuperAdminAddSchoolToSchoolAdmin'])
    ->name('superadmin.schooladmins.edit');
    

    Route::get('/admins/school/permissions/{id}', [App\Http\Controllers\AdminController::class, 'SuperAdminViewSchoolPermissions'])
    ->name('superadmin.school.permissions.view');
    Route::put('/admins/school/permissions/{id}', [App\Http\Controllers\AdminController::class, 'SuperAdminViewSchoolPermissions'])
    ->name('superadmin.school.permissions.view');


    /**
     *  Route : SuperAdmin / View All Schools
     *  # Display list of all schools 
     */
    Route::get('/school/view', [App\Http\Controllers\SchoolController::class, 'SuperAdminViewSchool'])
    ->name('superadmin.schools.view');
     /**
     * Route SuperAdmin / Delete School
     */
    Route::delete('/school/view/{id}', [App\Http\Controllers\SchoolController::class, 'SuperAdminDeleteSchool'])
    ->name('superadmin.schools.delete');
    /**
     *  Route : SuperAdmin / Create School
     * # Super Admin Create More Schools , Inshort display a School create Form
     */
    Route::get('/school/create', [App\Http\Controllers\SchoolController::class, 'SuperAdminCreateSchool'])
    ->name('superadmin.schools.create');
    Route::post('/school/create', [App\Http\Controllers\SchoolController::class, 'SuperAdminCreateSchool'])
    ->name('superadmin.schools.post');

    /**
     *  Route Admin / update School
     *  # Display Update Form and Update Record
     */
    Route::get('/school/{id}/edit', [App\Http\Controllers\SchoolController::class, 'SuperAdminEditSchool'])
    ->name('superadmin.schools.edit');
    Route::put('/school/{id}/edit', [App\Http\Controllers\SchoolController::class, 'SuperAdminEditSchool'])
    ->name('superadmin.schools.edit');

    /**
     *  Route Admin / View Students
     *  # Display list of all students in all Schools
     */
    Route::get('/students/view', [App\Http\Controllers\StudentsController::class, 'SuperAdminViewStudents'])
    ->name('superadmin.students.view');
    Route::post('/students/view', [App\Http\Controllers\StudentsController::class, 'SuperAdminViewStudents'])
    ->name('superadmin.students.view');
    /**
     * Route SuperAdmin / Delete Student
     */
    Route::delete('/students/view/{id}', [App\Http\Controllers\StudentsController::class, 'SuperAdminDeleteStudent'])
    ->name('superadmin.students.delete');
    /**
     *  Route Admin / create Student
     *  # Display Update Form and Update Record
     */
    Route::get('/students/create', [App\Http\Controllers\StudentsController::class, 'SuperAdminCreateStudents'])
    ->name('superadmin.students.create');
    Route::post('/students/create', [App\Http\Controllers\StudentsController::class, 'SuperAdminCreateStudents'])
    ->name('superadmin.students.create');
     /**
     *  Route Admin / update Student
     *  # Display Update Form and Update Record
     */
    Route::get('/students/{id}/edit', [App\Http\Controllers\StudentsController::class, 'SuperAdminEditStudent'])
    ->name('superadmin.students.edit');
    Route::put('/students/{id}/edit', [App\Http\Controllers\StudentsController::class, 'SuperAdminEditStudent'])
    ->name('superadmin.students.edit');
    /**
     * Route Admin / view Teachers
     * # Display a list of all teachers
     */
    Route::get('/teachers/view', [App\Http\Controllers\TeachersController::class, 'SuperAdminViewTeachers'])
    ->name('superadmin.teachers.view');
    /**
     * Route SuperAdmin / Delete Teacher
     */
    Route::delete('/teachers/view/{id}', [App\Http\Controllers\TeachersController::class, 'SuperAdminDeleteTeachers'])
    ->name('superadmin.teachers.delete');
    /**
     *  Route Admin / update Teacher
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/teachers/{id}/edit', [App\Http\Controllers\TeachersController::class, 'SuperAdminEditTeachers'])
    ->name('superadmin.teachers.edit');
    /**
     *  Route Admin / create Teacher
     *  # Display Update Form and Update Record
     */
    Route::get('/teachers/create', [App\Http\Controllers\TeachersController::class, 'SuperAdminCreateTeachers'])
    ->name('superadmin.teachers.create');
    Route::post('/teachers/create', [App\Http\Controllers\TeachersController::class, 'SuperAdminCreateTeachers'])
    ->name('superadmin.teachers.create');

    /**
     *  Route : SuperAdmin / View All Content
     *  # Display list of all Content 
     */
    Route::get('/lms/content/view', [App\Http\Controllers\ContentController::class, 'SuperAdminViewLMSContent'])
    ->name('superadmin.lms.content.view');
    Route::post('/lms/content/view', [App\Http\Controllers\ContentController::class, 'SuperAdminViewLMSContent'])
    ->name('superadmin.lms.content.view');
    /**
     *  Route Admin / update Content
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/lms/content/{id}/edit', [App\Http\Controllers\ContentController::class, 'SuperAdminEditLMSContent'])
    ->name('superadmin.lms.content.edit');
    Route::put('/lms/content/{id}/edit', [App\Http\Controllers\ContentController::class, 'SuperAdminEditLMSContent'])
    ->name('superadmin.lms.content.edit');
    /**
     * Route SuperAdmin / Delete Teacher
     */
    Route::delete('/lms/content/view/{id}', [App\Http\Controllers\ContentController::class, 'SuperAdminDeleteLMSContent'])
    ->name('superadmin.lms.content.delete');

    /**
     *  Route Admin / create Content
     *  # Display Update Form and Update Record
     */
    Route::get('/lms/content/create', [App\Http\Controllers\ContentController::class, 'SuperAdminCreateLMSContent'])
    ->name('superadmin.lms.content.create');
    Route::post('/lms/content/create', [App\Http\Controllers\ContentController::class, 'SuperAdminCreateLMSContent'])
    ->name('superadmin.lms.content.create');
    
     /**
     *  Route Admin / create Content
     *  # Filter to get chapters based on course id
     */
    Route::post('/lms/filter/chapter', [App\Http\Controllers\ContentController::class, 'filterChapter'])
    /**
    *  Route Admin / create Content
    *  # Filter to get chapters based on chapter id
    */
    ->name('superadmin.lms.filter.chapter');

    Route::post('/lms/filter/slo', [App\Http\Controllers\ContentController::class, 'filterSLO'])
    ->name('superadmin.lms.filter.slo');

    /**
     *  Route : SuperAdmin / View All Classes
     *  # Display list of all classes 
     */
    Route::get('/lms/classes/view', [App\Http\Controllers\TClassesController::class, 'SuperAdminViewLMSClasses'])
    ->name('superadmin.lms.classes.view');
    Route::delete('/lms/classes/view/{id}', [App\Http\Controllers\TClassesController::class, 'SuperAdminDeleteLMSClasses'])
    ->name('superadmin.lms.classes.delete');
    /**
     *  Route Admin / create LMS Class
     *  # Display Form To Create a new Record
     */
    Route::get('/lms/classes/create', [App\Http\Controllers\TClassesController::class, 'SuperAdminCreateLMSClasses'])
    ->name('superadmin.lms.classes.create');
    Route::post('/lms/classes/create', [App\Http\Controllers\TClassesController::class, 'SuperAdminCreateLMSClasses'])
    ->name('superadmin.lms.classes.create');
    /**
     *  Route Admin / update class
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/lms/classes/{id}/edit', [App\Http\Controllers\TClassesController::class, 'SuperAdminEditLMSClasses'])
    ->name('superadmin.lms.classes.edit');
    Route::put('/lms/classes/{id}/edit', [App\Http\Controllers\TClassesController::class, 'SuperAdminEditLMSClasses'])
    ->name('superadmin.lms.classes.edit');
    /**
     *  Route : SuperAdmin / View All Classes
     *  # Display list of all classes 
     */
    Route::get('/lms/boards/view', [App\Http\Controllers\BoardController::class, 'SuperAdminViewLMSBoard'])
    ->name('superadmin.lms.boards.view');
    Route::delete('/lms/boards/view/{id}', [App\Http\Controllers\BoardController::class, 'SuperAdminDeleteLMSBoard'])
    ->name('superadmin.lms.boards.delete');
    /**
     *  Route Admin / create LMS Board
     *  # Display Form To Create a new Record
     */
    Route::get('/lms/boards/create', [App\Http\Controllers\BoardController::class, 'SuperAdminCreateLMSBoard'])
    ->name('superadmin.lms.boards.create');
    Route::post('/lms/boards/create', [App\Http\Controllers\BoardController::class, 'SuperAdminCreateLMSBoard'])
    ->name('superadmin.lms.boards.create');
     /**
     *  Route Admin / update LMS BOARD
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/lms/boards/{id}/edit', [App\Http\Controllers\BoardController::class, 'SuperAdminEditLMSBoard'])
    ->name('superadmin.lms.boards.edit');
     /**
     *  Route : SuperAdmin / View All Subjects
     *  # Display list of all Subjects 
     */
    Route::get('/lms/subjects/view', [App\Http\Controllers\TCoursesController::class, 'SuperAdminViewLMSSubjects'])
    ->name('superadmin.lms.subjects.view');
    Route::delete('/lms/subjects/view/{id}', [App\Http\Controllers\TCoursesController::class, 'SuperAdminDeleteLMSSubjects'])
    ->name('superadmin.lms.subjects.delete');
    /**
     *  Route Admin / create LMS Subject
     *  # Display Form To Create a new Record
     */
    Route::get('/lms/subjects/create', [App\Http\Controllers\TCoursesController::class, 'SuperAdminCreateLMSSubjects'])
    ->name('superadmin.lms.subjects.create');
    Route::post('/lms/subjects/create', [App\Http\Controllers\TCoursesController::class, 'SuperAdminCreateLMSSubjects'])
    ->name('superadmin.lms.subjects.create');
    /**
     *  Route Admin / update LMS Subjects
     *  # Display Update Form and Update Record
     */
    Route::get('/lms/subjects/{id}/edit', [App\Http\Controllers\TCoursesController::class, 'SuperAdminEditLMSSubjects'])
    ->name('superadmin.lms.subjects.edit');
    Route::put('/lms/subjects/{id}/edit', [App\Http\Controllers\TCoursesController::class, 'SuperAdminEditLMSSubjects'])
    ->name('superadmin.lms.subjects.edit');
    /**
    *  Route : SuperAdmin / View All Chapters
    *  # Display list of all Chapter of subjects 
    */
    Route::get('/lms/chapters/view', [App\Http\Controllers\TChapterController::class, 'SuperAdminViewLMSChapters'])
    ->name('superadmin.lms.chapters.view');
    Route::delete('/lms/chapters/view/{id}', [App\Http\Controllers\TChapterController::class, 'SuperAdminDeleteLMSChapters'])
    ->name('superadmin.lms.chapters.delete');
    /**
     *  Route Admin / create LMS chapters
     *  # Display Form To Create a new Record
     */
    Route::get('/lms/chapters/create', [App\Http\Controllers\TChapterController::class, 'SuperAdminCreateLMSChapters'])
    ->name('superadmin.lms.chapters.create');
    Route::post('/lms/chapters/create', [App\Http\Controllers\TChapterController::class, 'SuperAdminCreateLMSChapters'])
    ->name('superadmin.lms.chapters.create');
    /**
     *  Route Admin / update LMS Chapters
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/lms/chapters/{id}/edit', [App\Http\Controllers\TChapterController::class, 'SuperAdminEditLMSChapters'])
    ->name('superadmin.lms.chapters.edit');
    /**
     * Route Admin / view SLO
     * # Display a list of all Topics of Chapters
     */
    Route::get('/lms/slo/view', [App\Http\Controllers\TtopicsController::class, 'SuperAdminViewSLO'])
    ->name('superadmin.lms.slo.view');
    Route::delete('/lms/slo/view/{id}', [App\Http\Controllers\TtopicsController::class, 'SuperAdminDeleteSLO'])
    ->name('superadmin.lms.slo.delete');
    /**
     *  Route Admin / create LMS SLO
     *  # Display Form To Create a new Record
     */
    Route::get('/lms/slo/create', [App\Http\Controllers\TtopicsController::class, 'SuperAdminCreateSLO'])
    ->name('superadmin.lms.slo.create');
    Route::post('/lms/slo/create', [App\Http\Controllers\TtopicsController::class, 'SuperAdminCreateSLO'])
    ->name('superadmin.lms.slo.create');
    /**
     *  Route Admin / update LMS SLO
     *  # Display Update Form and Update Record
     *  #-----------READ----------------------NOT IMPLEMENTED YET-----------------------READ--------------#
     */
    Route::get('/lms/slo/{id}/edit', [App\Http\Controllers\TtopicsController::class, 'SuperAdminEditSLO'])
    ->name('superadmin.lms.slo.edit');
    /**
     * Route Admin / View Ecoaching Plans
     * # Display a list of all Topics of Chapters
     */
    Route::get('/ecoaching/plans/view', [App\Http\Controllers\EPlanController::class, 'SuperAdminViewPlans'])
    ->name('superadmin.ecoaching.plans.view');
    /**
     * Route Admin / View Ecoaching Plans
     * # Display a list of all Topics of Chapters
     */
    Route::get('/ecoaching/plans/create', [App\Http\Controllers\EPlanController::class, 'SuperAdminCreatePlans'])
    ->name('superadmin.ecoaching.plans.create');
    Route::post('/ecoaching/plans/create', [App\Http\Controllers\EPlanController::class, 'SuperAdminCreatePlans'])
    ->name('superadmin.ecoaching.plans.create');
    /**
     * Route Admin / View Ecoaching Plans
     * # Display a list of all Topics of Chapters
     */
    Route::get('/ecoaching/plan/{id}/edit', [App\Http\Controllers\EPlanController::class, 'SuperAdminEditPlan'])
    ->name('superadmin.ecoaching.plan.edit');
    
    Route::post('/ecoaching/plan/{id}/add/course', [App\Http\Controllers\EPlanController::class, 'SuperAdminEditPlanAddCourse'])
    ->name('e-learning.plan.addCourse');
    /**
     * Route Admin / View Ecoaching Plans
     * # Display a list of all Students
     */
    Route::get('/ecoaching/students/view', [App\Http\Controllers\EStudentsController::class, 'SuperAdminViewStudents'])
    ->name('superadmin.ecoaching.students.view');
    /**
     * Route Admin / View Ecoaching Plans
     * # Display a list of all Ecoaching Students
     */
    Route::get('/ecoaching/students/create', [App\Http\Controllers\EStudentsController::class, 'SuperAdminCreateStudents'])
    ->name('superadmin.ecoaching.students.create');
    Route::post('/ecoaching/students/create', [App\Http\Controllers\EStudentsController::class, 'SuperAdminCreateStudents'])
    ->name('superadmin.ecoaching.students.create');
    /**
     * Route Admin / View Ecoaching Teachers
     * # Display a list of all Teachers
     */
    Route::get('/ecoaching/teachers/view', [App\Http\Controllers\EPlanController::class, 'SuperAdminViewTeachers'])
    ->name('superadmin.teachers.view');
    /**
     * Route Admin / View Ecoaching Teachers
     * # Display a list of all Teachers
     */
    Route::get('/ecoaching/live_session/view', [App\Http\Controllers\EContentController::class, 'SuperAdminViewLiveSession'])
    ->name('superadmin.live_session.view');
    /**
     * Route Admin / View Ecoaching Teachers
     * # Display a list of all Teachers
     */
    Route::get('/ecoaching/live_session/create', [App\Http\Controllers\EContentController::class, 'SuperAdminCreateLiveSession'])
    ->name('superadmin.live_session.create');
    Route::post('/ecoaching/live_session/create', [App\Http\Controllers\EContentController::class, 'SuperAdminCreateLiveSession'])
    ->name('superadmin.live_session.create');
    /**
     * Route Admin / View Ecoaching Teachers
     * # Display a list of all Teachers
     */
    Route::get('/ecoaching/notes/view', [App\Http\Controllers\EContentController::class, 'SuperAdminViewNotes'])
    ->name('superadmin.notes.view');
    /**
     * Route Admin / View Ecoaching Teachers
     * # Display a list of all Teachers
     */
    Route::get('/ecoaching/notes/create', [App\Http\Controllers\EContentController::class, 'SuperAdminCreateNotes'])
    ->name('superadmin.notes.create');
    Route::post('/ecoaching/notes/create', [App\Http\Controllers\EContentController::class, 'SuperAdminCreateNotes'])
    ->name('superadmin.notes.create');
});