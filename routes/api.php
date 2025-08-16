<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AcademicDataController;

// Auth Routes //
Route::post('register-or-login', [AuthController::class, 'registerOrLogin']);
Route::post('verify-code'      , [AuthController::class, 'verifyCode']);
Route::post('resend-code'      , [AuthController::class, 'resendCode'])->middleware('throttle:10,1');

// Academic Data Routes //
Route::get('academic-data', [AcademicDataController::class, 'getAcademicData']);
Route::get('universities' , [AcademicDataController::class, 'getUniversities']);
Route::get('colleges'     , [AcademicDataController::class, 'getCollegesByUniversity']);
Route::get('grades'       , [AcademicDataController::class, 'getGradesByCollege']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('complete-profile', [AuthController::class, 'completeProfile']);
    Route::post('logout'          , [AuthController::class, 'logout']);

    // Home Routes //
    Route::get('subjects'         , [HomeController::class, 'getUserSubjects']);
});
