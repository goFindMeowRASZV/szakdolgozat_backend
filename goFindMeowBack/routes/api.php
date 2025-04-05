<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShelteredCatController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ------------------------------
// Role-based middleware usage:
// 'role:admin' = role 0
// 'role:staff' = role 1
// 'role:user' = role 2
// ------------------------------

// Ezeket bárki elérheti:
Route::get('/get-sheltered-reports', [ReportController::class, 'get_sheltered_reports']);
Route::get('/get-map-reports', [ReportController::class, 'get_map_reports']);

// Autentikáció
Route::middleware('auth:sanctum')->get('/whoami', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => $request->user()->role,
    ]);
});

// Admin + Staff 
Route::middleware(['auth:sanctum', 'role:admin,staff'])->group(function () {
    Route::patch('/reports/{id}/archive', [ReportController::class, 'archive']);
    Route::get('/get-users', [UserController::class, 'index']);
    Route::post('/create-user', [UserController::class, 'createUser']);
    Route::put('/update-report/{id}', [ReportController::class, 'updateReport']);
    Route::put('/update-sheltered-cat/{id}', [ShelteredCatController::class, 'updateShelteredCat']);

});


// Admin + Staff + User 
Route::middleware(['auth:sanctum', 'role:admin,staff,user'])->group(function () {
    Route::post('/create-report', [ReportController::class, 'store']);
    Route::get('/get-reports', [ReportController::class, 'index']);
    Route::post('/create-comment', [CommentController::class, 'store']);
    Route::get('/get-sheltered-report-filter/{color},{pattern}', [ReportController::class, 'get_sheltered_reports_filter']);
    Route::get('/get-report-filter/{status},{color},{pattern}', [ReportController::class, 'get_reports_filter']);
});

// ADMIN 

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::put('/admin/update-user/{id}', [UserController::class, 'update']);

    Route::get('/admin/get-user/{id}', [UserController::class, 'show']);
    Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);

    Route::get('/admin/get-report/{id}', [ReportController::class, 'show']);
    Route::delete('/admin/delete-report/{id}', [ReportController::class, 'destroy']);
    Route::post('/admin/create-report', [ReportController::class, 'store']);

    Route::get('/admin/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
    Route::delete('/admin/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
    Route::post('/admin/create-sheltered-cat', [ShelteredCatController::class, 'store']);

    Route::get('/admin/get-user-comments/{user_id}', [CommentController::class, 'show']);
    Route::get('/admin/get-comment/{id}', [CommentController::class, 'show']);
    Route::delete('/admin/delete-comment/{id}', [CommentController::class, 'destroy']);
});

// STAFF 
Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
    Route::get('/staff/get-report/{id}', [ReportController::class, 'show']);
    Route::delete('/staff/delete-report/{id}', [ReportController::class, 'destroy']);
    Route::post('/staff/create-report', [ReportController::class, 'store']);

    Route::get('/staff/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
    Route::delete('/staff/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
    Route::post('/staff/create-sheltered-cat', [ShelteredCatController::class, 'store']);

    Route::post('/staff/create-comment', [CommentController::class, 'store']);
});

// AUTHENTICATED USER 
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::delete('/delete-report/{id}', [ReportController::class, 'destroy']);

    Route::post('/shelter-cat', [ShelteredCatController::class, 'store']);

    Route::get('/get-comment/{id}', [CommentController::class, 'show']);
    Route::get('/comments/by-report/{reportId}', [CommentController::class, 'getCommentsByReport']);

    Route::post('/profile-picture', [UserController::class, 'uploadPicture']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
});
