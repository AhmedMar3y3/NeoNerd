<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;

require __DIR__.'/doctor.php';

//public routes
Route::get('/',            [AdminAuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin',[AdminAuthController::class, 'loginUser'])->name('loginUser');


//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout',  [AdminAuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard',[AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

    // // store routes //
    // Route::get('/stores',               [StoreController::class, 'index'])->name('admin.stores.index');
    // Route::get('/stores/{id}',          [StoreController::class, 'show'])->name('admin.stores.show');
    // Route::post('/stores/{id}/activate',[StoreController::class, 'activate'])->name('admin.stores.activate');

    // // order routes //
    // Route::get('/orders',                 [OrderController::class,'index'])->name('admin.orders.index');
    // Route::get('/orders/{id}',            [OrderController::class,'show'])->name('admin.orders.show');
    // Route::post('/assign-delegate/{order}',[OrderController::class,'assignDelegate'])->name('admin.orders.assign');

    // // delegates routes //
    // Route::get('/delegates',              [DelegateController::class,'index'])->name('admin.delegates.index');
    // Route::get('/delegates/{id}',         [DelegateController::class,'show'])->name('admin.delegates.show');
    // Route::delete('/delete-delegate/{id}',[DelegateController::class,'destroy'])->name('admin.delegates.destroy');
});