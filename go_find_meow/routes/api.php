<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/users', [UserController::class, 'index']);

Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);  

//csrf
/* Route::get('/sanctum/csrf-cookie',function(){
    return response()-> json('CSRF token set');
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    //autentikált útvonal, user
});


Route::middleware(['auth:sanctum'])
->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

//admin útvonal
Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
}); */


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
