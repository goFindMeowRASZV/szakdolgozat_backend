<?php

use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShelteredCatController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// vendeg
Route::get('/get-sheltered-reports', [ReportController::class, 'get_sheltered_reports']);
Route::get('/get-map-reports', [ReportController::class, 'get_map_reports']);
Route::get('/comments/by-report/{reportId}', [CommentController::class, 'getCommentsByReport']);
Route::get('/get-sheltered-report-filter/{color},{pattern}', [ReportController::class, 'get_sheltered_reports_filter']);
Route::get('/get-report-filter/{status},{color},{pattern}', [ReportController::class, 'get_reports_filter']);
Route::get('/reports-search', [ReportController::class, 'search']);
Route::get('/sheltered-reports-search', [ShelteredCatController::class, 'search']);

// auth
Route::middleware('auth:sanctum')->get('/whoami', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => $request->user()->role,
        'name' => $request->user()->name,
        'created_at' => $request->user()->created_at,
        'profile_picture' => $request->user()->profile_picture
            ? asset($request->user()->profile_picture)
            : null,
    ]);
});



// Admin + Staff 
Route::middleware(['auth:sanctum', 'role:admin,staff'])->group(function () {
    Route::get('/get-users', [UserController::class, 'index']);
    Route::post('/create-user', [UserController::class, 'createUser']);
    Route::put('/update-reports/{id}', [ReportController::class, 'updateReport']);
    Route::put('/update-sheltered-cat/{id}', [ShelteredCatController::class, 'updateShelteredCat']);
    Route::get('/get-adopted-sheltered-reports', [ReportController::class, 'get_adopted_cats']);

});


// Admin + Staff + User 
Route::middleware(['auth:sanctum', 'role:admin,staff,user'])->group(function () {
    Route::post('/create-report', [ReportController::class, 'store']);
    Route::get('/get-reports', [ReportController::class, 'index']);
    Route::post('/create-comment', [CommentController::class, 'store']);

    Route::post('/profile-picture', [UserController::class, 'uploadPicture']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
});

// ADMIN 

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::put('/admin/update-user/{id}', [UserController::class, 'update']);
    Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);
    Route::delete('/delete-comment/{report}/{user}', [CommentController::class, 'destroy']);

});

// STAFF 
Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
    Route::delete('/staff/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
    Route::post('/staff/create-sheltered-cat', [ShelteredCatController::class, 'store']);
    Route::patch('/sheltered-cats/{id}/orokbeadas', [ShelteredCatController::class, 'orokbeadas']);

});

// USER 
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::post('/orokbefogadas', [AdoptionRequestController::class, 'send']);

});
