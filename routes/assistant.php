<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Assistant\AuthController;
use App\Http\Controllers\Assistant\SubscriptionController;

Route::prefix('assistant')->group(function () {

    Route::get('/'      , [AuthController::class, 'loadLoginPage'])->name('assistantloginPage');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('loginAssistant');

    //protected routes
    Route::middleware(['auth.assistant'])->group(function () {
        Route::post('/logout',  [AuthController::class, 'logout'])->name('assistant.logout');
        Route::get('/dashboard',[AuthController::class, 'dashboard'])->name('assistant.dashboard');

        // Subscription routes
        Route::resource('subscriptions', SubscriptionController::class, ['as' => 'assistant']);
        Route::post('subscriptions/{subscription}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('assistant.subscriptions.toggle-status');
        Route::post('subscriptions/bulk-action', [SubscriptionController::class, 'bulkAction'])->name('assistant.subscriptions.bulk-action');
        Route::get('subscriptions/user/{user}', [SubscriptionController::class, 'getUserSubscriptions'])->name('assistant.subscriptions.user');
        Route::get('subscriptions/course/{course}', [SubscriptionController::class, 'getContentSubscriptions'])->name('assistant.subscriptions.content');
    });
});
