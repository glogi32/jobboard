<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CompanyDetailsController;
use App\Http\Controllers\JobDetailsController;
use App\Http\Controllers\Resource\CompanyController;
use App\Http\Controllers\Resource\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get("/company-details/get-comments",[CompanyDetailsController::class,"getAllCommentsForCompany"]);



// Route::prefix("options")->group(function(){
//     Route::resource("companies",CompanyController::class);
//     Route::resource("jobs",JobController::class);
// });

// Route::prefix("admin")->group(function(){
//     Route::resource("users",UserController::class);
// });
