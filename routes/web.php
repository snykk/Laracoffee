<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// pre authenticate
Route::middleware(['alreadyLogin'])->group(function () {
    // landing
    Route::get('/', function () {
        return view('landing.index', [
            "title" => "Landing",
        ]);
    });

    // Login
    Route::get('/{url}', [AuthController::class, "loginGet"])->where(["url" => "auth|auth/login"])->name("auth");
    Route::post('/auth/login', [AuthController::class, "loginPost"]);

    // Register
    Route::get('/auth/register', [AuthController::class, "registrationGet"]);
    Route::post('/auth/register', [AuthController::class, "registrationPost"]);
});

// main
Route::middleware(['auth'])->group(function () {
    // Home
    Route::controller(HomeController::class)->group(function () {
        Route::get("/home", "index")->name("home");
        Route::get("/home/customers", "customers");
    });

    // profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get("/profile/my_profile", "myProfile");
        Route::get("/profile/edit_profile", "editProfileGet");
        Route::post("/profile/edit_profile/{user:id}", "editProfilePost");
    });

    // Logout
    Route::post('/auth/logout', [AuthController::class, "logoutPost"]);
});
