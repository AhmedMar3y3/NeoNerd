<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;



// Auth Routes
Route::post('register-or-login', [UserAuthController::class, 'registerOrLogin']);
Route::post('verify-code'      , [UserAuthController::class, 'verifyCode']);
Route::post('resend-code', [UserAuthController::class, 'resendCode'])->middleware('throttle:10,1');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('complete-profile', [UserAuthController::class, 'completeProfile']);
    Route::post('logout', [UserAuthController::class, 'logout']);
});
