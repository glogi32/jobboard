<?php

use App\Http\Controllers\Admin\CompaniesController as CompaniesAdminController;
use App\Http\Controllers\Admin\JobsController as JobsAdminController;
use App\Http\Controllers\Admin\UsersController as UsersAdminController;
use App\Http\Controllers\Resource\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController as ResourceCompanyController;
use App\Http\Controllers\CompanyDetailsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
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

Route::get('/', [IndexController::class,"index"])->name("/");

Route::get("/test",function(){
    return view("admin.layout.admin-template");
});

Route::get('/home', [IndexController::class,"index"])->name("home");

Route::get('/contact', function () {
    return view('pages.contact');
})->name("contact");

Route::get('/sign-up', function () {
    return view('pages.sign-up');
})->name("sign-up-page");

Route::get('/login', function () {
    return view('pages.login');
})->name("login-page");


Route::get("/jobs",[ResourceJobController::class,"index"])->name("jobs");

Route::get("/companies",[ResourceCompanyController::class,"index"])->name("companies");

Route::get("/company-details/{id}",[CompanyDetailsController::class,"index"])->name("company-details");
Route::post("/company-details/insert-comment",[CompanyDetailsController::class,"insertComment"]);
Route::delete("/company-details/delete-comment/{id}",[CompanyDetailsController::class,"deleteComment"]);
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
    Route::get("users",[UsersAdminController::class,"usersPage"])->name("users-page");
    Route::get("jobs",[JobsAdminController::class,"jobsPage"])->name("jobs-page");
    Route::get("companies",[CompaniesAdminController::class,"companiesPage"])->name("companies-page");

    Route::get("user-edit/{id}",[UsersAdminController::class,"usersEditPage"])->name("user-edit-admin");

    Route::get("companies-stats",[CompaniesAdminController::class, "topCompaniesStatistics"]);
    Route::get("jobs-stats",[JobsAdminController::class, "topJobsStatistics"]);

    Route::resource("users-api",UserController::class);
    Route::resource("jobs-api",JobController::class);
    Route::resource("companies-api",CompanyController::class);
});