<?php

use App\Http\Controllers\API\FarmerControllerAPI;
use App\Http\Controllers\API\FarmerLelangStingController;
use App\Http\Controllers\API\FarmerTransactionStingController;
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
    //done
    UserControllerAPI::class, "CekEmailForRegister"
]);
Route::get("/nanoid", [
    //done
    UserControllerAPI::class, "nanoIdAPI"
]);
Route::post("/login", [
    //done
    UserControllerAPI::class, "Login"
]);
Route::post("/register", [
    //done
    UserControllerAPI::class, "Register"
]);

Route::get('user/get/token', [
    //done
    UserControllerAPI::class, "GetProfile"
]);
Route::get("/category/fetch", [
    //done
    FarmerControllerAPI::class, "FetchCategory"
]);
Route::get("/sting/fetch", [
    //done
    FarmerControllerAPI::class, "FetchSting"
]);
Route::get("/sting/most", [
    //done
    FarmerControllerAPI::class, "MostOrderedStingThisMonth"
]);
Route::get("/sting/category/{category}", [
    //done
    FarmerControllerAPI::class, "FetchStingByCategory"
]);
Route::get("/sting/{id}", [
    //done
    FarmerControllerAPI::class, "GetSting"
]);
Route::middleware("auth.apirequest")->group(function () {
    //middleware ini akan melakukan pengecekkan apa token api request sesuai

    Route::get("/sting/transaction/fetch", [
        //done
        FarmerTransactionStingController::class, "FetchTransactionSting"
    ]);
    Route::get("/sting/transaction/fetch/{status}", [
        //done
        FarmerTransactionStingController::class, "FetchTransactionStingByStatus"
    ]);

    Route::get("/sting/transaction/{id}/cancel", [
        //done
        FarmerTransactionStingController::class, "CancelTransactionSting"
    ]);
    Route::get("/sting/transaction/{id}/complains", [
        //done
        FarmerTransactionStingController::class, "FetchComplainTransactionSting"
    ]);
    Route::post("/sting/transaction/{id}/decline", [
        //done
        FarmerTransactionStingController::class, "DeclineTransactionSting"
    ]);
    Route::post("/sting/transaction/{id}/accept", [
        //done
        FarmerTransactionStingController::class, "CompleteTransactionSting"
    ]);
    Route::get("/sting/transaction/{id}", [
        //done
        FarmerTransactionStingController::class, "GetTransactionSting"
    ]);


    Route::get("/sting/lelang/fetch", [
        //done
        FarmerLelangStingController::class, "FetchLelangSting"
    ]);
    Route::post("/sting/lelang/make", [
        //done
        FarmerLelangStingController::class, "AuctionMakeProcess"
    ]);
    Route::get("/sting/lelang/{id}/cancel", [
        //done
        FarmerLelangStingController::class, "CancelLelangSting"
    ]);
    Route::get("/sting/lelang/{id}/complains", [
        //done
        FarmerLelangStingController::class, "FetchComplainLelangSting"
    ]);
    Route::get("/sting/lelang/{id}/decline", [
        //done
        FarmerLelangStingController::class, "DeclineLelangSting"
    ]);
    Route::get("/sting/lelang/{id}/accept", [
        //done
        FarmerLelangStingController::class, "CompleteLelangSting"
    ]);
    Route::get("/sting/lelang/{id}", [
        //done
        FarmerLelangStingController::class, "GetLelangSting"
    ]);




    Route::post('sting/buy/{kode}/{mode}', [
        //done
        FarmerTransactionStingController::class, "BuySting"
    ]);

    // Route::get("sting/ordered/download/{name}", function ($name) {
    //     try {
    //         if (env("APP_ENV") == "production") {
    //             // return Storage::download("order-deliver/$name", "hasil.jpg");
    //             return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/" . $name);
    //         } else {
    //             return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
    //         }
    //     } catch (Exception) {
    //         return response()->json([
    //             'success'   => false,
    //             'message'   => 'Hasil file tidak ditemukan!',
    //             'data'      =>  "{}"
    //         ], 404);
    //     }
    // });


    //user profile
    Route::get('user/get', [
        //done
        UserControllerAPI::class, "GetProfile"
    ]);
    // Route::get('user/get/image', [
    //     //tidak jadi dipakai
    //     UserControllerAPI::class, "GetImage"
    // ]);
    Route::post('user/password', [
        //done
        UserControllerAPI::class, "ChangePassword"
    ]);
    Route::post('user/picture', [
        //done
        UserControllerAPI::class, "PictureUpdate"
    ]);
    Route::post('user/profile', [
        //done
        UserControllerAPI::class, "ProfileUpdate"
    ]);
    Route::post('user/topup', [
        //done
        UserControllerAPI::class, "topup"
    ]);
});
