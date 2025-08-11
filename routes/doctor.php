<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DoctorAuthController;

Route::prefix('doctor')->group(function () {

    // Route::get('/', [AuthController::class, 'loadLoginPage'])->name('storeloginPage');
    // Route::post('/login', [AuthController::class, 'loginUser'])->name('loginStore');
    // Route::get('/register', [AuthController::class, 'loadRegisterPage'])->name('register');
    // Route::post('/register-user', [AuthController::class, 'registerUser'])->name('registerUser');

    // //protected routes
    // Route::middleware(['auth.store'])->group(function () {
    //     Route::get('/dashboard', [HomeController::class, 'stats'])->name('store.dashboard');
    //     Route::post('/toggle-open-close', [HomeController::class, 'toggleOpenClose'])->name('store.toggleOpenClose');
    //     Route::post('/logout',  [AuthController::class, 'logout'])->name('store.logout');

    //     // profile routes //
    //     Route::get('/profile', [ProfileController::class, 'getProfile'])->name('store.profile.index');
    //     Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('store.profile.update');
    //     Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('store.profile.password');
    // });
});
