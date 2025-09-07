<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\FavouriteController;
use App\Http\Controllers\User\AcademicDataController;
use App\Http\Controllers\Public\VersionController;

// Auth Routes //
Route::post('register-or-login', [AuthController::class, 'registerOrLogin']);
Route::post('verify-code'      , [AuthController::class, 'verifyCode']);
Route::post('resend-code'      , [AuthController::class, 'resendCode'])->middleware('throttle:10,1');

// Academic Data Routes //
Route::get('academic-data', [AcademicDataController::class, 'getAcademicData']);
Route::get('universities' , [AcademicDataController::class, 'getUniversities']);
Route::get('colleges'     , [AcademicDataController::class, 'getCollegesByUniversity']);
Route::get('grades'       , [AcademicDataController::class, 'getGradesByCollege']);

// Public Version Routes //
Route::get('app-versions', [VersionController::class, 'getVersions']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('complete-profile', [AuthController::class, 'completeProfile']);
    Route::post('logout'          , [AuthController::class, 'logout']);
    Route::get('fetch-settings'   , [Controller::class, 'fetchSettings']);
    
    // Profile Routes //
    Route::get('/profile'            , [ProfileController::class, 'getProfile']);
    Route::put('/update-profile-info', [ProfileController::class, 'updatePersonalInfo']);
    Route::put('/update-study-info'  , [ProfileController::class, 'updateStudyInfo']);
    Route::put('/update-phone'       , [ProfileController::class, 'updatePhone']);

    // Favourites Routes //
    Route::get('/favourites'              , [FavouriteController::class, 'list']);
    Route::post('/toggle-favourite/{id}'  , [FavouriteController::class, 'toggleFavorite']);

    // Home Routes //
    Route::get('banners'              , [HomeController::class, 'banners']);
    Route::get('subjects'             , [HomeController::class, 'getUserSubjects']);
    Route::get('recommended-courses'  , [HomeController::class, 'getRecommendedCourses']);
    Route::get('newest-courses'       , [HomeController::class, 'getNewestCourses']);
    Route::get('courses/{id}'         , [HomeController::class, 'getCourseDetails']);
    Route::get('courses-ratings/{id}' , [HomeController::class, 'courseRatings']);
    Route::post('rate-course/{id}'    , [HomeController::class, 'rateCourse']);

});