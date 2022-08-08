<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RajaOngkirController;
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
        Route::get("/home", "index");
        Route::get("/home/customers", "customers");
    });

    // profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get("/profile/my_profile", "myProfile");
        Route::get("/profile/edit_profile", "editProfileGet");
        Route::post("/profile/edit_profile/{user:id}", "editProfilePost");
        Route::get("/profile/change_password", "changePasswordGet");
        Route::post("/profile/change_password", "changePasswordPost");
    });

    // Product
    Route::controller(ProductController::class)->group(function () {
        Route::get("/product", "index");
        Route::get("/product/add_product", "addProductGet");
        Route::get("/product/edit_product/{product:id}", "editProductGet");
        Route::post("/product/add_product", "addProductPost");
        Route::post("/product/edit_product/{product:id}", "editProductPost");
        Route::get("/product/data/{id}", "getProductData");
    });

    // Order
    Route::controller(OrderController::class)->group(function () {
        Route::get("/order/make_order/{product:id}", "makeOrderGet");
        Route::get("/order/order_data", "orderData");
        Route::get("/order/order_data/{status_id}", "orderDataFilter");
        Route::get("/order/data/{id}", "getOrderData");
        Route::post("/order/make_order/{product:id}", "makeOrderPost");
    });

    // Ongkir
    Route::controller(RajaOngkirController::class)->group(function () {
        Route::get("/shipping/province", "province");
        Route::get("/shipping/city/{province_id}", "city");
        Route::get("/shipping/cost/{origin}/{destination}/{quantity}/{courier}", "cost");
    });

    // Logout
    Route::post('/auth/logout', [AuthController::class, "logoutPost"]);
});
