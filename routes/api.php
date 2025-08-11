<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\AcademicDataController;

// Auth Routes
Route::post('register-or-login', [UserAuthController::class, 'registerOrLogin']);
Route::post('verify-code'      , [UserAuthController::class, 'verifyCode']);
Route::post('resend-code', [UserAuthController::class, 'resendCode'])->middleware('throttle:10,1');

// Academic Data Routes (Public)
Route::get('academic-data', [AcademicDataController::class, 'getAcademicData']);
Route::get('universities', [AcademicDataController::class, 'getUniversities']);
Route::get('colleges', [AcademicDataController::class, 'getCollegesByUniversity']);
Route::get('grades', [AcademicDataController::class, 'getGradesByCollege']);
Route::get('secondary-types', [AcademicDataController::class, 'getSecondaryTypes']);
Route::get('secondary-grades', [AcademicDataController::class, 'getSecondaryGrades']);
Route::get('secondary-sections', [AcademicDataController::class, 'getSecondarySections']);
Route::get('scientific-branches', [AcademicDataController::class, 'getScientificBranches']);

// Subject Routes (Public)
Route::get('subjects/academic-level', [AcademicDataController::class, 'getSubjectsByAcademicLevel']);
Route::get('subjects/college-grade', [AcademicDataController::class, 'getSubjectsByCollegeGrade']);
Route::get('subjects/secondary-type', [AcademicDataController::class, 'getSubjectsBySecondaryType']);
Route::get('subjects/secondary-grade', [AcademicDataController::class, 'getSubjectsBySecondaryGrade']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [UserAuthController::class, 'getProfile']);
    Route::post('complete-profile', [UserAuthController::class, 'completeProfile']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    
    // Subject Routes (Authenticated)
    Route::get('subjects/user', [AcademicDataController::class, 'getUserSubjects']);
});
