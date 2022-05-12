<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(AuthController::class)->group(function(){
    Route::post('/send-otp','sendOtp')->name('api.sendotp');
    Route::post('/login','login')->name('api.login')->middleware('attempts');//attemps middleware check login attempts.Defined in app\Http\Middelware\CheckExceededAttempts.middleware named $routeMiddleware in app\Http\Kernel.php
});