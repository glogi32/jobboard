<?php

use App\Http\Controllers\Resource\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController as ResourceCompanyController;
use App\Http\Controllers\CompanyDetailsController;
use App\Http\Controllers\JobController as ResourceJobController;
use App\Http\Controllers\JobDetailsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\Resource\ApplicationController;
use App\Http\Controllers\Resource\CompanyController;
use App\Http\Controllers\Resource\JobController;
use App\Http\Controllers\UserProfileController;

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
    return view('pages.home');
})->name("/");
Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::get('/sign-up', function () {
    return view('pages.sign-up');
});

Route::get('/login', function () {
    return view('pages.login');
});


Route::get("/jobs",[ResourceJobController::class,"index"])->name("jobs");

Route::get("/companies",[ResourceCompanyController::class,"index"])->name("companies");

Route::get("/company-details/{id}",[CompanyDetailsController::class,"index"])->name("company-details");
Route::post("/company-details/insert-comment",[CompanyDetailsController::class,"insertComment"]);
Route::post("/company-details/{id}/vote",[CompanyDetailsController::class,"vote"]);
Route::patch("/company-details/updateVote",[CompanyDetailsController::class,"updateVote"])->name("update-vote");

Route::get("/job-details/{id}",[JobDetailsController::class,"index"])->name("job-details");
Route::post("/job-details/save-job",[JobDetailsController::class,"saveJob"]);
Route::delete("/job-details/unsave-job",[JobDetailsController::class,"unsaveJob"]);
Route::post("/job-details/job-apply",[JobDetailsController::class,"jobApplication"])->name("job-apply");

Route::prefix("options")->group(function(){
    Route::get('/user-edit',[OptionController::class,"index"])->name("user-edit");
    Route::get('/user-companies',[OptionController::class,"companies"])->name("user-companies");
    Route::get('/user-jobs',[OptionController::class,"jobs"])->name("user-jobs");
    Route::get('/saved-jobs',[OptionController::class,"savedJobs"])->name("saved-jobs");
    Route::get('/user-applications',[OptionController::class,"applications"])->name("user-applications");
    
    Route::resource("companies",CompanyController::class);
    Route::resource("jobs",JobController::class);
    Route::resource("applications",ApplicationController::class);
});




Route::get("/user-profile/{id}",[UserProfileController::class,"index"])->name("user-profile");

Route::post("/sign-up",[AuthController::class,"signUp"])->name("sign-up");
Route::post("/login",[AuthController::class,"login"])->name("login");
Route::get("/logout",[AuthController::class,"logout"])->name("logout");
Route::get("/verify",[AuthController::class,"verifyAccount"]);

Route::delete("/remove-user-cv",[OptionController::class,"removeUserCV"])->name("remove-cv");
Route::delete("/remove-user-docs",[OptionController::class,"removeUserDocs"])->name("remove-docs");

Route::prefix("admin")->group(function(){
    Route::resource("users",UserController::class);
});