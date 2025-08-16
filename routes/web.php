<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UniversityController;

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

});