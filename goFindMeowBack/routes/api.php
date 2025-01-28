<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [Controller::class, 'index']);


Route::post('/create-report',[ReportController::class,'store']);