<?php

use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// route for api
Route::prefix('v1/')->name('api.')->group(function () {

    // routes for auth
    Route::controller(ApiAuthController::class)->name('auth.')->group(function () {
        // route that contain guest_api_sanctum middleware
        Route::middleware('guest_api_sanctum')->group(function () {
            // auth routes
            Route::post('/login', 'login')->name('login');
            Route::post('/register', 'register')->name('register');
        });

        // route that contain ensure_api_authenticated middleware
        Route::middleware('ensure_api_authenticated')->group(function () {
            // verify email
            Route::middleware('should_not_verify_email')->group(function () {
                Route::post('/verify', 'verify')->name('verify');
                Route::post('verify/resend', 'resend')->name('verify.resend');
            });
            // logout
            Route::post('/logout', 'logout')->name('logout');
        });
    });

    // routes for reset password
    Route::controller(PasswordResetController::class)->name('password.')->prefix('password/')->middleware('guest_api_sanctum')->group(function () {
        Route::post('send/code', 'sendCode')->name('send.code');
        Route::post('reset', 'reset')->name('reset.code');
    });

    // get user api
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => true,
            'user' => Auth::guard('sanctum')->user(),
        ], 200);
    })->middleware(['ensure_api_authenticated', 'should_email_verified']);
});
