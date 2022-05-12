<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return to_route('email.otp.view');//redirects to send-otp interface
})->name('home');

//Auth::routes();
Auth::routes(['register' => false,'login'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::controller(UserController::class)->group(function(){ //all functions described in UserController
    Route::get('/send-otp','emailOtpView')->name('email.otp.view')->middleware('guest');//cannot access this page when successfully logged in-guest middeleware used.
    Route::post('/send-otp-send','emailOtpSend')->name('email.otp.send');
    Route::get('/confirm-otp','otpConfirmationView')->name('otp.confirmation.view')->middleware('guest');//cannot access this page when successfully logged in-guest middeleware used.
    Route::post('/login-with-otp','otpConfirmationLogin')->name('otp.confirmation.login')->middleware('attempts');//attemps middleware check login attempts.Defined in app\Http\Middelware\CheckExceededAttempts.middleware named $routeMiddleware in app\Http\Kernel.php
});
