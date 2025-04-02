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
Route::get('/get-sheltered-reports', [ReportController::class, 'get_sheltered_reports']);

Route::middleware('auth:sanctum')->get('/whoami', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => $request->user()->role,
    ]);
});


// Archiválás – admin és staff is elérheti
Route::middleware(['auth:sanctum', 'role:admin,staff'])
    ->patch('/reports/{id}/archive', [ReportController::class, 'archive']);

Route::middleware(['auth:sanctum', 'role:admin,staff,user'])
    ->post('/create-report', [ReportController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:admin,staff,user'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum', 'role:admin,staff,user'])
    ->get('/get-reports', [ReportController::class, 'index']);


// ------------------------------
// ADMIN ROUTES
// ------------------------------
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Users
    Route::get('/admin/get-users', [UserController::class, 'index']);
    Route::get('/admin/get-user/{id}', [UserController::class, 'show']);
    Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);

    // Reports
    Route::get('/admin/get-report/{id}', [ReportController::class, 'show']);
    Route::delete('/admin/delete-report/{id}', [ReportController::class, 'destroy']);
    Route::post('/admin/create-report', [ReportController::class, 'store']);

    // Sheltered Cats
    Route::get('/admin/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
    Route::delete('/admin/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
    Route::post('/admin/create-sheltered-cat', [ShelteredCatController::class, 'store']);

    // Comments
    Route::get('/admin/get-user-comments/{user_id}', [CommentController::class, 'show']);
    Route::get('/admin/get-comment/{id}', [CommentController::class, 'show']);
    Route::delete('/admin/delete-comment/{id}', [CommentController::class, 'destroy']);
});

// ------------------------------
// STAFF ROUTES
// ------------------------------
Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
    // Reports
    Route::get('/staff/get-report/{id}', [ReportController::class, 'show']);
    Route::delete('/staff/delete-report/{id}', [ReportController::class, 'destroy']);
    Route::post('/staff/create-report', [ReportController::class, 'store']);

    // Sheltered Cats
    Route::get('/staff/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
    Route::delete('/staff/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
    Route::post('/staff/create-sheltered-cat', [ShelteredCatController::class, 'store']);

    // Comments
    Route::post('/staff/create-comment', [CommentController::class, 'store']);
});

// ------------------------------
// AUTHENTICATED USER ROUTES
// ------------------------------
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Reports
    Route::get('/get-sheltered-reports', [ReportController::class, 'get_sheltered_reports']);
    Route::delete('/delete-report/{id}', [ReportController::class, 'destroy']);

    // Sheltered Cats
    Route::post('/shelter-cat', [ShelteredCatController::class, 'store']);
    Route::get('/get-sheltered-report-filter/{color},{pattern}', [ReportController::class, 'get_sheltered_reports_filter']);

    // Filters
    Route::get('/get-report-filter/{status},{color},{pattern}', [ReportController::class, 'get_reports_filter']);

    // Comments
    Route::get('/get-comment/{id}', [CommentController::class, 'show']);
    Route::get('/comments/by-report/{reportId}', [CommentController::class, 'getCommentsByReport']);
    Route::post('/create-comment', [CommentController::class, 'store']);

    //Profil
    Route::post('/profile-picture', [UserController::class, 'uploadPicture']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
});
