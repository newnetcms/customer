<?php

use Illuminate\Http\Request;
use Newnet\Customer\Http\Controllers\Api\AuthenticatedSessionController;
use Newnet\Customer\Http\Controllers\Api\NewPasswordController;
use Newnet\Customer\Http\Controllers\Api\PasswordResetLinkController;
use Newnet\Customer\Http\Controllers\Api\RegisteredUserController;

Route::prefix('v1/customer')
    ->group(function() {
        // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');
        // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

        Route::middleware('guest:customer')->group(function() {
            Route::post('register', [RegisteredUserController::class, 'store']);
            Route::post('login', [AuthenticatedSessionController::class, 'store']);
            Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
            Route::post('reset-password', [NewPasswordController::class, 'store']);
        });

        Route::middleware(['auth:sanctum'])->group(function() {
            Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
            Route::get('info', function(Request $request) {
                return $request->user();
            });
        });
    });
