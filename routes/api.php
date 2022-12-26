<?php

use App\Http\Controllers\API\FarmerControllerAPI;
use App\Http\Controllers\API\UserControllerAPI;
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


Route::get("/", function () {
    return response("hello", 200);
});
Route::get("/cek/email", [
    UserControllerAPI::class, "CekEmailForRegister"
]);
Route::get("/nanoid", [
    UserControllerAPI::class, "nanoIdAPI"
]);
Route::post("/login", [
    UserControllerAPI::class, "Login"
]);
Route::post("/register", [
    UserControllerAPI::class, "Register"
]);
Route::get("/category/fetch", [
    FarmerControllerAPI::class, "FetchCategory"
]);
Route::get("/sting/fetch", [
    FarmerControllerAPI::class, "FetchSting"
]);
Route::get("/sting/most", [
    FarmerControllerAPI::class, "MostOrderedStingThisMonth"
]);
Route::get("/sting/category/{category}", [
    FarmerControllerAPI::class, "FetchStingByCategory"
]);
Route::middleware("auth.apirequest")->group(function () {
    //middleware ini akan melakukan pengecekkan apa token api request sesuai

    Route::get("/sting/transaction/fetch", [
        FarmerControllerAPI::class, "FetchTransactionSting"
    ]);
    Route::get("/sting/lelang/fetch", [
        FarmerControllerAPI::class, "FetchLelangSting"
    ]);
    Route::post("/sting/lelang/make", [
        FarmerControllerAPI::class, "AuctionMakeProcess"
    ]);
    Route::post('sting/buy/{kode}/{mode}', [
        FarmerControllerAPI::class, "BuySting"
    ]);

    Route::get("sting/ordered/download/{name}", function ($name) {
        try {
            if (env("APP_ENV") == "production") {
                // return Storage::download("order-deliver/$name", "hasil.jpg");
                return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/" . $name);
            } else {
                return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
            }
        } catch (Exception) {
            return response()->json([
                'success'   => false,
                'message'   => 'Hasil file tidak ditemukan!',
                'data'      =>  "{}"
            ], 404);
        }
    });


    //user profile
    Route::get('user/get', [
        UserControllerAPI::class, "GetProfile"
    ]);
    Route::get('user/get/image', [
        UserControllerAPI::class, "GetImage"
    ]);
    Route::post('user/password', [
        UserControllerAPI::class, "ChangePassword"
    ]);
    Route::post('user/picture', [
        UserControllerAPI::class, "PictureUpdate"
    ]);
    Route::post('user/profile', [
        UserControllerAPI::class, "ProfileUpdate"
    ]);
    Route::post('user/topup', [
        UserControllerAPI::class, "topup"
    ]);
});
