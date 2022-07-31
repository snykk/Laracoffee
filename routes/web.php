<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('landing.index', [
        "title" => "Landing",
        "css" => "landing"
    ]);
});

Route::get('/{url}', [AuthController::class, "loginGet"])->where(["url" => "auth|auth/login"]);
Route::post('/auth/login', [AuthController::class, "loginPost"]);

Route::get('/auth/register', [AuthController::class, "registrationGet"]);
Route::post('/auth/register', [AuthController::class, "registrationPost"]);
