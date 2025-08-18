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

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update-profile-info', [\App\Http\Controllers\User\ProfileController::class, 'updatePersonalInfo']);
    Route::put('/update-profile-studing', [\App\Http\Controllers\User\ProfileController::class, 'updateStudyInfo']);
    Route::put('/update-phone', [\App\Http\Controllers\User\ProfileController::class, 'updatePhone']);

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favourites', [\App\Http\Controllers\User\FavouriteController::class, 'index']);       // list favourites
    Route::post('/favourites', [\App\Http\Controllers\User\FavouriteController::class, 'store']);      // add to favourites
    Route::delete('/favourites/{courseId}', [\App\Http\Controllers\User\FavouriteController::class, 'destroy']); // remove favourite
});



Route::middleware('auth:api')->prefix('notifications')->group(function () {

    // ترجع كل النوتيفيكيشن بتاعت اليوزر
    Route::get('/', function () {
        return response()->json(
            auth()->user()->notifications
        );
    });

    // تجيب نوتيفيكيشن معينة
    Route::get('/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        return response()->json($notification);
    });

    // تحدد نوتيفيكيشن معين انه اتقري
    Route::patch('/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    });

    // تعملهم كلهم مقريين
    Route::patch('/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'All notifications marked as read']);
    });

    // تمسح نوتيفيكيشن معينة
    Route::delete('/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['message' => 'Notification deleted']);
    });

    // تمسح كل النوتيفيكيشن
    Route::delete('/', function () {
        auth()->user()->notifications()->delete();
        return response()->json(['message' => 'All notifications deleted']);
    });
});
