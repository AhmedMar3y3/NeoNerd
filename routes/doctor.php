<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\AuthController;
use App\Http\Controllers\Doctor\ProfileController;
use App\Http\Controllers\Doctor\CourseController;
use App\Http\Controllers\Doctor\UnitController;
use App\Http\Controllers\Doctor\LessonController;
use App\Http\Controllers\Doctor\AssistantController;
use App\Http\Controllers\Doctor\SubscriptionController;

Route::prefix('doctor')->group(function () {

    Route::get('/'      , [AuthController::class, 'loadLoginPage'])->name('doctorloginPage');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('loginDoctor');

    //protected routes
    Route::middleware(['auth.doctor'])->group(function () {
        Route::post('/logout',  [AuthController::class, 'logout'])->name('doctor.logout');
        Route::get('/dashboard',[AuthController::class, 'dashboard'])->name('doctor.dashboard');

        // profile routes //
        Route::get('/profile', [ProfileController::class, 'getProfile'])->name('doctor.profile.index');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('doctor.profile.update');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('doctor.profile.password');

        // courses routes //
        Route::get('/courses', [CourseController::class, 'index'])->name('doctor.courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('doctor.courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('doctor.courses.store');
        Route::get('/courses/{id}', [CourseController::class, 'show'])->name('doctor.courses.show');
        Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('doctor.courses.edit');
        Route::put('/courses/{id}', [CourseController::class, 'update'])->name('doctor.courses.update');
        Route::post('/courses/{id}/toggle-status', [CourseController::class, 'toggleStatus'])->name('doctor.courses.toggle-status');
        Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('doctor.courses.destroy');

        // units routes //
        Route::get('/courses/{courseId}/units', [UnitController::class, 'index'])->name('doctor.courses.units.index');
        Route::get('/courses/{courseId}/units/create', [UnitController::class, 'create'])->name('doctor.courses.units.create');
        Route::post('/courses/{courseId}/units', [UnitController::class, 'store'])->name('doctor.courses.units.store');
        Route::get('/courses/{courseId}/units/{id}', [UnitController::class, 'show'])->name('doctor.courses.units.show');
        Route::get('/courses/{courseId}/units/{id}/edit', [UnitController::class, 'edit'])->name('doctor.courses.units.edit');
        Route::put('/courses/{courseId}/units/{id}', [UnitController::class, 'update'])->name('doctor.courses.units.update');
        Route::delete('/courses/{courseId}/units/{id}', [UnitController::class, 'destroy'])->name('doctor.courses.units.destroy');

        // lessons routes //
        Route::get('/courses/{courseId}/units/{unitId}/lessons', [LessonController::class, 'index'])->name('doctor.courses.units.lessons.index');
        Route::get('/courses/{courseId}/units/{unitId}/lessons/create', [LessonController::class, 'create'])->name('doctor.courses.units.lessons.create');
        Route::post('/courses/{courseId}/units/{unitId}/lessons', [LessonController::class, 'store'])->name('doctor.courses.units.lessons.store');
        Route::get('/courses/{courseId}/units/{unitId}/lessons/{id}', [LessonController::class, 'show'])->name('doctor.courses.units.lessons.show');
        Route::get('/courses/{courseId}/units/{unitId}/lessons/{id}/edit', [LessonController::class, 'edit'])->name('doctor.courses.units.lessons.edit');
        Route::put('/courses/{courseId}/units/{unitId}/lessons/{id}', [LessonController::class, 'update'])->name('doctor.courses.units.lessons.update');
        Route::delete('/courses/{courseId}/units/{unitId}/lessons/{id}', [LessonController::class, 'destroy'])->name('doctor.courses.units.lessons.destroy');

        // assistants routes //
        Route::get('/assistants', [AssistantController::class, 'index'])->name('doctor.assistants.index');
        Route::get('/assistants/create', [AssistantController::class, 'create'])->name('doctor.assistants.create');
        Route::post('/assistants', [AssistantController::class, 'store'])->name('doctor.assistants.store');
        Route::get('/assistants/{assistant}/edit', [AssistantController::class, 'edit'])->name('doctor.assistants.edit');
        Route::put('/assistants/{assistant}', [AssistantController::class, 'update'])->name('doctor.assistants.update');
        Route::post('/assistants/{assistant}/toggle-status', [AssistantController::class, 'toggleStatus'])->name('doctor.assistants.toggle-status');
        Route::delete('/assistants/{assistant}', [AssistantController::class, 'destroy'])->name('doctor.assistants.destroy');

        // subscriptions routes //
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('doctor.subscriptions.index');
        Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('doctor.subscriptions.create');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('doctor.subscriptions.store');
        Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show'])->name('doctor.subscriptions.show');
        Route::get('/subscriptions/{id}/edit', [SubscriptionController::class, 'edit'])->name('doctor.subscriptions.edit');
        Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update'])->name('doctor.subscriptions.update');
        Route::post('/subscriptions/{id}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('doctor.subscriptions.toggle-status');
        Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('doctor.subscriptions.destroy');
        Route::post('/subscriptions/bulk-action', [SubscriptionController::class, 'bulkAction'])->name('doctor.subscriptions.bulk-action');
        Route::get('/subscriptions/user/{userId}', [SubscriptionController::class, 'getUserSubscriptions'])->name('doctor.subscriptions.user');
        Route::get('/subscriptions/content/{type}/{contentId}', [SubscriptionController::class, 'getContentSubscriptions'])->name('doctor.subscriptions.content');
    });
});
