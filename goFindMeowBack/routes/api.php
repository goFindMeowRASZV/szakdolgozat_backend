<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [Controller::class, 'index']);


Route::post('/create-report', [ReportController::class, 'store']);


/* Admin:

Users-> userek lekérése, együtt vagy egysével 		/admin/users  | /admin/user/{id}  GET
	user törlése					/admin/user/{id}  		  DELETE
	user létrehozása 				/admin/user/adatok 		  POST
	user adatainak szerkesztése 			/admin/user/{id} 		  PATCH

Reports -> bejelentések lekérése, együtt vagy egysével  /admin/reports  | /admin/report/{id}  GET
	   bejelentés törlése				/admin/report/{id}  DELETE
	   bejelentés létrehozása 			/admin/create-report 	 	      POST  '/create-report'
	   bejelentés adatainak szerkesztése 		/admin/report/{id} 		      PATCH

Sheltered_cats -> menhelyi macskák lekérése, együtt vagy egysével  /admin/sheltered_cats  | /admin/sheltered_cat/{id}  	GET
	   	  menhelyi macska törlése 			   /admin/sheltered_cat/{id}  	DELETE
	   	  menhelyi macska létrehozása 			   /admin/sheltered_cat/adatok 			      	POST
	   	  menhelyi macska adatainak szerkesztése	   /admin/sheltered_cat/{id} 		      		PATCH

Commments ->	 kommentek lekérése, együtt vagy egysével  /admin/commments  | /admin/comment/{id}  	GET
	   	 komment törlése 			   /admin/comment/{id}  			DELETE
	   	 komment létrehozása 			   /admin/comment/adatok 			POST
 */

Route::get('/admin/users', [UserController::class, 'index']);
Route::get('/admin/users/{id}', [UserController::class, 'show']);
Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
Route::post('/admin/users', [UserController::class, 'store']);
Route::patch('/admin/users/{id}', [UserController::class, 'update']);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // Kijelentkezés útvonal
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    });

Route::middleware(['auth:sanctum', Admin::class])
    ->group(function () {
        Route::get('/admin/users', [UserController::class, 'index']);

        Route::get('/admin/users', [UserController::class, 'index']);
        Route::get('/admin/users/{id}', [UserController::class, 'show']);
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
        Route::post('/admin/users', [UserController::class, 'store']);
        Route::patch('/admin/users/{id}', [UserController::class, 'update']);
    });
