<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\SettingController;
use App\Models\Ticket;

// dashboard routes
Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
});

// users routes
Route::controller(UserController::class)->prefix('user/')->name('user.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{user}', 'show')->name('show');
    Route::get('/{user}/edit', 'edit')->name('edit');
    Route::put('/{user}', 'update')->name('update');
    Route::delete('/{user}', 'destroy')->name('destroy');
});

// cities routes
Route::controller(CityController::class)->prefix('city/')->name('city.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{city}/edit', 'edit')->name('edit');
        Route::get('/{city}', 'show')->name('show');
        Route::put('/{city}', 'update')->name('update');
        Route::delete('/{city}', 'destroy')->name('destroy');
});

// events routes
Route::controller(EventController::class)->prefix('event/')->name('event.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{event}/edit', 'edit')->name('edit');
    Route::put('/{event}', 'update')->name('update');
    Route::delete('/{event}', 'destroy')->name('destroy');
});

// hotels route
Route::controller(HotelController::class)->prefix('hotel/')->name('hotel.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{hotel}/edit', 'edit')->name('edit');
    Route::put('/{hotel}', 'update')->name('update');
    Route::delete('/{hotel}', 'destroy')->name('destroy');
});

// tickets routes
Route::controller(TicketController::class)->prefix('ticket/')->name('ticket.')->group(function () {
    Route::get('/', 'index')->name('index');
});

// bookings routes
Route::controller(BookingController::class)->prefix('booking/')->name('booking.')->group(function (){
    Route::get('/', 'index')->name('index');
});

// profile routes
Route::controller(ProfileController::class)->prefix('profile/')->name('profile.')->group(function () {
    Route::get('/edit', 'edit')->name('edit');
    Route::put('/', 'update')->name('update');
    Route::put('/password', 'updatePassword')->name('updatePassword');
});

// profile routes
Route::controller(ProfileController::class)->prefix('/profile')->name('profile.')->group(function(){
    Route::get('edit/', 'edit')->name('edit');
});

Route::controller(SettingController::class)->prefix('/setting')->name('setting.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
});

// logout route
Route::controller(AdminAuthController::class)->name('auth.')->group(function () {
    Route::post('logout', 'logout')->name('logout');
});
