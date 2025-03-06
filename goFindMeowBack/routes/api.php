<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShelteredCatController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Staff;
use App\Models\ShelteredCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/* Route::get('/get-report-filter/{color},{pattern},{date1},{date2}', [ReportController::class, 'get_sheltered_reports_filter']); */
//Route::post('/create-report', [ReportController::class, 'store']);


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

//Admin
Route::middleware(['auth:sanctum', Admin::class])
    ->group(function () {
        //Users
        Route::get('/admin/get-users', [UserController::class, 'index']);
        Route::get('/admin/get-user/{id}', [UserController::class, 'show']);
        Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);
/*         Route::post('/admin/create-user', [UserController::class, 'store']);
 *//*         Route::patch('/admin/patch-user/{id}', [UserController::class, 'update']);
 */        //Reports


        Route::get('/admin/get-report/{id}', [ReportController::class, 'show']);
        Route::delete('/admin/delete-report/{id}', [ReportController::class, 'destroy']);
        Route::post('/admin/create-report', [ReportController::class, 'store']);
/*         Route::patch('/admin/patch-report/{id}', [ReportController::class, 'update']);
 */
        //menhelyi macskák report adatai
    

        //ShelteredCats
        Route::get('/admin/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
        Route::delete('/admin/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
        Route::post('/admin/create-sheltered-cat', [ShelteredCatController::class, 'store']);
/*         Route::patch('/admin/patch-sheltered-cat/{id}', [ShelteredCatController::class, 'update']);
 */        //Comments
        /* Route::get('/admin/get-comment/{id}', [CommentController::class, 'show']);
        Route::delete('/admin/delete-comment/{id}', [CommentController::class, 'destroy']);
        Route::post('/admin/create-comment', [CommentController::class, 'store']);
 */

        Route::get('/admin/get-user-comments/{user_id}',[CommentController::class,'show']);  //!!!
    });

//Staff
Route::middleware(['auth:sanctum', Staff::class])
    ->group(function () {
        //Reports
        Route::get('/staff/get-report/{id}', [ReportController::class, 'show']);

      

        Route::delete('/staff/delete-report/{id}', [ReportController::class, 'destroy']);
        Route::post('/staff/create-report', [ReportController::class, 'store']);
/*         Route::patch('/staff/patch-report/{id}', [ReportController::class, 'update']);
 */        //ShelteredCats
        Route::get('/staff/get-sheltered-cat/{id}', [ShelteredCatController::class, 'show']);
        Route::delete('/staff/delete-sheltered-cat/{id}', [ShelteredCatController::class, 'destroy']);
        Route::post('/staff/create-sheltered-cat', [ShelteredCatController::class, 'store']);
/*         Route::patch('/staff/patch-sheltered-cat/{id}', [ShelteredCatController::class, 'update']);
 */        //Comments
        Route::post('/staff/create-comment', [CommentController::class, 'store']);
    });

//autentikált réteg->USER
Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // Kijelentkezés útvonal
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

        //Reports
        Route::get('/get-reports', [ReportController::class, 'index']);
    

        Route::get('/get-sheltered-reports', [ReportController::class, 'get_sheltered_reports']);
        Route::delete('/delete-report/{id}', [ReportController::class, 'destroy']);
        //Comments
        Route::post('/create-comment', [CommentController::class, 'store']);

        /*         Route::post('/shelter-cat', [ReportController::class, 'shelter_cat']);
 */     
        Route::post('/create-report', [ReportController::class, 'store']);
        Route::post('/shelter-cat', [ShelteredCatController::class, 'store']);
        
        Route::get('/get-sheltered-report-filter/{status},{color},{pattern}', [ReportController::class, 'get_sheltered_reports_filter']);
        Route::get('/get-report-filter/{status},{color},{pattern}', [ReportController::class, 'get_reports_filter']);
    });
