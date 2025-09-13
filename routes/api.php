<?php

use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// route for Api
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

    // routes for profile
    Route::controller(ProfileController::class)->name('profile.')->prefix('profile/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
    });

    // routes for home
    Route::controller(HomeController::class)->name('home.')->prefix('home/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // routes for events
    Route::controller(EventController::class)->name('event.')->prefix('event/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function(){
        Route::get('/{id}', 'show')->name('show');
    });

    // routes for hotels
    Route::controller(HotelController::class)->name('hotels.')->prefix('hotel/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function (){
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

    // routes for favorites
    Route::controller(FavoriteController::class)->name('favorite.')->prefix('favorite/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function(){
        Route::post('update', 'update')->name('update');
    });

    // routes for orders
    Route::controller(OrderController::class)->name('order.')->prefix('order/')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function(){
        Route::post('store', 'store')->name('store');
        Route::get('/showUserOrders', 'showUserOrder')->name('showUserOrder');
    });

    // routes for filters
    Route::controller(FilterController::class)->name('filter.')->prefix('/filter')->middleware('ensure_api_authenticated', 'should_email_verified')->group(function(){
        Route::get('/getDetails', 'getDetails')->name('getDetails');
        Route::get('', 'index')->name('index');
    });
});
