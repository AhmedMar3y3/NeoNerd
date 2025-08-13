<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Home\AcademicDataController;
use App\Http\Controllers\Home\UserHomeController;

// Auth Routes
Route::post('register-or-login', [UserAuthController::class, 'registerOrLogin']);
Route::post('verify-code'      , [UserAuthController::class, 'verifyCode']);
Route::post('resend-code'      , [UserAuthController::class, 'resendCode'])->middleware('throttle:10,1');

// Academic Data Routes
Route::get('academic-data', [AcademicDataController::class, 'getAcademicData']);
Route::get('universities' , [AcademicDataController::class, 'getUniversities']);
Route::get('colleges'     , [AcademicDataController::class, 'getCollegesByUniversity']);
Route::get('grades'       , [AcademicDataController::class, 'getGradesByCollege']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('complete-profile', [UserAuthController::class, 'completeProfile']);
    Route::post('logout'          , [UserAuthController::class, 'logout']);

    // User Subjects
    Route::get('subjects'         , [UserHomeController::class, 'getUserSubjects']);
});
