<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\SubscriptionController;

require __DIR__.'/doctor.php';

// public routes //
Route::get('/',            [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin',[AuthController::class, 'loginUser'])->name('loginUser');

// protected routes //
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard',[AuthController::class, 'dashboard'])->name('admin.dashboard');

    // Users routes //
    Route::get('/users'                    , [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}'               , [UserController::class, 'show'])->name('admin.users.show');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/users/{id}'            , [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Subjects routes //
    Route::get('/subjects'                    , [SubjectController::class, 'index'])->name('admin.subjects.index');
    Route::get('/subjects/create'             , [SubjectController::class, 'create'])->name('admin.subjects.create');
    Route::post('/subjects'                   , [SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::get('/subjects/{id}/edit'          , [SubjectController::class, 'edit'])->name('admin.subjects.edit');
    Route::put('/subjects/{id}'               , [SubjectController::class, 'update'])->name('admin.subjects.update');
    Route::post('/subjects/{id}/toggle-status', [SubjectController::class, 'toggleStatus'])->name('admin.subjects.toggle-status');
    Route::delete('/subjects/{id}'            , [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');
    Route::get('/subjects/{id}'               , [SubjectController::class, 'show'])->name('admin.subjects.show');

    // Universities routes //
    Route::get('/universities'          , [UniversityController::class, 'index'])->name('admin.universities.index');
    Route::post('/universities'         , [UniversityController::class, 'store'])->name('admin.universities.store');
    Route::get('/universities/{id}/edit', [UniversityController::class, 'show'])->name('admin.universities.edit');
    Route::put('/universities/{id}'     , [UniversityController::class, 'update'])->name('admin.universities.update');
    Route::delete('/universities/{id}'  , [UniversityController::class, 'destroy'])->name('admin.universities.destroy');

    // Colleges routes //
    Route::get('/universities/{university}/colleges'          , [CollegeController::class, 'index'])->name('admin.universities.colleges.index');
    Route::post('/universities/{university}/colleges'         , [CollegeController::class, 'store'])->name('admin.universities.colleges.store');
    Route::get('/universities/{university}/colleges/{id}/edit', [CollegeController::class, 'show'])->name('admin.universities.colleges.edit');
    Route::put('/universities/{university}/colleges/{id}'     , [CollegeController::class, 'update'])->name('admin.universities.colleges.update');
    Route::delete('/universities/{university}/colleges/{id}'  , [CollegeController::class, 'destroy'])->name('admin.universities.colleges.destroy');

    // Grades routes //
    Route::get('/universities/{university}/colleges/{college}/grades'          , [GradeController::class, 'index'])->name('admin.universities.colleges.grades.index');
    Route::post('/universities/{university}/colleges/{college}/grades'         , [GradeController::class, 'store'])->name('admin.universities.colleges.grades.store');
    Route::get('/universities/{university}/colleges/{college}/grades/{id}/edit', [GradeController::class, 'show'])->name('admin.universities.colleges.grades.edit');
    Route::put('/universities/{university}/colleges/{college}/grades/{id}'     , [GradeController::class, 'update'])->name('admin.universities.colleges.grades.update');
    Route::delete('/universities/{university}/colleges/{college}/grades/{id}'  , [GradeController::class, 'destroy'])->name('admin.universities.colleges.grades.destroy');

    // Banner routes //
    Route::get('/banners'        , [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/{id}'   , [BannerController::class, 'show'])->name('admin.banners.show');
    Route::post('/banners'       , [BannerController::class, 'store'])->name('admin.banners.store');
    Route::put('/banners/{id}'   , [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');

    
    // Setting routes //
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Doctors routes //
    Route::get('/doctors'                    , [DoctorController::class, 'index'])->name('admin.doctors.index');
    Route::get('/doctors/create'             , [DoctorController::class, 'create'])->name('admin.doctors.create');
    Route::post('/doctors'                   , [DoctorController::class, 'store'])->name('admin.doctors.store');
    Route::get('/doctors/{id}'               , [DoctorController::class, 'show'])->name('admin.doctors.show');
    Route::get('/doctors/{id}/edit'          , [DoctorController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('/doctors/{id}'               , [DoctorController::class, 'update'])->name('admin.doctors.update');
    Route::post('/doctors/{id}/toggle-status', [DoctorController::class, 'toggleStatus'])->name('admin.doctors.toggle-status');
    Route::delete('/doctors/{id}'            , [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');

    // Courses routes //
    Route::get('/courses'                    , [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/courses/{id}'               , [CourseController::class, 'show'])->name('admin.courses.show');
    Route::post('/courses/{id}/toggle-status', [CourseController::class, 'toggleStatus'])->name('admin.courses.toggle-status');
    Route::delete('/courses/{id}'            , [CourseController::class, 'destroy'])->name('admin.courses.destroy');

    // Subscriptions routes //
    Route::get('/subscriptions'                    , [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::get('/subscriptions/create'             , [SubscriptionController::class, 'create'])->name('admin.subscriptions.create');
    Route::post('/subscriptions'                   , [SubscriptionController::class, 'store'])->name('admin.subscriptions.store');
    Route::get('/subscriptions/{id}'               , [SubscriptionController::class, 'show'])->name('admin.subscriptions.show');
    Route::get('/subscriptions/{id}/edit'          , [SubscriptionController::class, 'edit'])->name('admin.subscriptions.edit');
    Route::put('/subscriptions/{id}'               , [SubscriptionController::class, 'update'])->name('admin.subscriptions.update');
    Route::post('/subscriptions/{id}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('admin.subscriptions.toggle-status');
    Route::delete('/subscriptions/{id}'            , [SubscriptionController::class, 'destroy'])->name('admin.subscriptions.destroy');
    Route::post('/subscriptions/bulk-action'       , [SubscriptionController::class, 'bulkAction'])->name('admin.subscriptions.bulk-action');
    Route::get('/subscriptions/user/{userId}'      , [SubscriptionController::class, 'getUserSubscriptions'])->name('admin.subscriptions.user');
    Route::get('/subscriptions/content/{type}/{contentId}', [SubscriptionController::class, 'getContentSubscriptions'])->name('admin.subscriptions.content');

});