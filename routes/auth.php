<?php

use App\Http\Controllers\Dashboard\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

// login route
Route::controller(AdminAuthController::class)->group(function(){
    Route::get('/login', 'showLoginForm')->name('showLoginForm');
    Route::post('/login', 'login')->name('login');
});
