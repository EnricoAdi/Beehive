<?php

use App\Http\Controllers\FrontEnd\AdminController;
use App\Http\Controllers\FrontEnd\BuyerController;
use App\Http\Controllers\FrontEnd\RouteController;
use App\Http\Controllers\FrontEnd\SellerController;
use App\Http\Controllers\FrontEnd\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!d
|
*/

Route::get("/", [PublicController::class, "LandingPage"])->name("landingpage");

//LOGIN AND REGISTER
Route::view("/login", "userAuth.login")->name("login")->middleware("auth.alreadylogin");
Route::post("/login", [
    UserController::class, "Login"
]);

Route::get("/forgot", [
    UserController::class, "ForgotView"
]);
Route::post("/forgot", [
    UserController::class, "ForgotSend"
]);

Route::get("verifyforgot/{code}", [
    UserController::class, "VerifyForgotView"
]);
Route::post("verifyforgot/{code}", [
    UserController::class, "VerifyForgot"
]);

Route::prefix("/register")->group(function () {

    Route::view("/", "userAuth.register")->name("register")->middleware("auth.alreadylogin");
    Route::post("/", [
        UserController::class, "Register"
    ]);
    Route::get("/send-email", [
        UserController::class, "EmailSendedView"
    ]);
});

Route::get("verify/{code}", [
    UserController::class, "VerifyEmail"
]);

/**
 * Alur verifikasi email
 *  Register -> send-email -> verify
 */

Route::middleware("auth.user")->group(function () {
    Route::prefix("admin")->middleware("auth.role.admin")->group(function () {
        Route::get('/', [
            //list sting
            AdminController::class, "Dashboard"
        ])->name("dashboardAdmin");

        Route::prefix("master")->group(function () {
            Route::get('/user', [
                AdminController::class, "MasterUserView"
            ]);
            Route::post('/user', [
                AdminController::class, "MasterUser"
            ]);

            Route::get('/user/detail/{email}/{from}', [
                AdminController::class, "DetailUserView"
            ]);

            Route::patch('/user/detail/{email}/{from}', [
                AdminController::class, "DetailUser"
            ]);

            //for deleting user
            Route::get('/user/delete/{email}/{from}', [
                AdminController::class, "DeleteEmail"
            ]);

            Route::get('/category', [
                AdminController::class, "MasterCategoryView"
            ]);

            Route::post('/category', [
                AdminController::class, "MasterCategory"
            ]);

            Route::get('/category/detail/{id}', [
                AdminController::class, "DetailCategoryView"
            ]);

            Route::patch('/category/detail/{id}', [
                AdminController::class, "DetailCategory"
            ]);
            //for deleting category
            Route::get('/category/delete/{id}', [
                AdminController::class, "DeleteCategory"
            ]);


            Route::get('/sting', [
                AdminController::class, "MasterStingView"
            ]);
            Route::get('/sting/{id}', [
                AdminController::class, "DetailStingView"
            ]);
            Route::post('/sting/{id}', [
                AdminController::class, "EditSting"
            ]);
            Route::get('/sting/delete/{id}/{catt}', [
                AdminController::class, "DeleteSting"
            ]);
        });

        Route::prefix("report")->group(function () {
            Route::get('/earnings', [
                AdminController::class, "ReportEarningsView"
            ]);
            Route::post('/earnings', [
                AdminController::class, "GetReportData"
            ]);
            Route::get('/topup', [
                AdminController::class, "ReportTopupView"
            ]);
            Route::post('/topup', [
                AdminController::class, "GetTopupReportData"
            ]);
            Route::get('/sting', [
                AdminController::class, "ReportStingView"
            ]);
            Route::post('/sting', [
                AdminController::class, "GetReportStingData"
            ]);
        });
        Route::get('logs', [
            AdminController::class, "LogsView"
        ]);
    });
    Route::prefix('seller')->middleware("auth.role.seller")->group(function () {
        Route::get('/', [
            //list sting
            SellerController::class, "Dashboard"
        ])->name("dashboardSeller");

        Route::prefix('sting')->group(function () {
            Route::get('/', [
                //list sting
                SellerController::class, "ListSting"
            ])->name("sellersting");

            Route::get('/upload', [
                //Upload sting
                SellerController::class, "AddStingView"
            ])->name("sellerUploadSting");
            Route::post('/upload', [
                //Upload sting
                SellerController::class, "AddSting"
            ]);
            Route::post('/edit/{id}', [
                //Upload sting
                SellerController::class, "EditSting"
            ]);
            Route::get('/edit/{id}', [
                //Upload sting
                SellerController::class, "EditStingView"
            ])->name("sellerEditSting");
            Route::get('/picture/{id}', [
                //Upload sting
                SellerController::class, "PictureStingView"
            ])->name("sellerPictureSting");

            Route::POST('/thumbnail/{id}', [
                //Upload sting
                SellerController::class, "PictureStingThumbnail"
            ]);
            Route::POST('/media1/{id}', [
                //Upload sting
                SellerController::class, "PictureMedia1Thumbnail"
            ]);
            Route::POST('/media2/{id}', [
                //Upload sting
                SellerController::class, "PictureMedia2Thumbnail"
            ]);
            Route::POST('/media3/{id}', [
                //Upload sting
                SellerController::class, "PictureMedia3Thumbnail"
            ]);
            Route::POST('/media4/{id}', [
                //Upload sting
                SellerController::class, "PictureMedia4Thumbnail"
            ]);
            Route::POST('/delete/{id}', [
                //Upload sting
                SellerController::class, "softDeleteSting"
            ]);


            Route::prefix('detail')->group(function () {

                Route::get("download/{name}", function ($name) {
                    try {
                        if (env("APP_ENV") == "production") {
                            // return Storage::download("order-deliver/$name", "hasil.jpg");
                            return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/".$name);
                        } else {
                            return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
                            // return Storage::download("storage/order-deliver/$name", "hasil.jpg");
                            // return Storage::download("/public/order-deliver/$name", "hasil.jpg");
                        }
                    } catch (Exception) {
                        return redirect("/seller/order")->with("error", "File not found");
                    }
                });
                Route::post('/chat/{id}', [
                    SellerController::class, "AddChat"
                ]);
                Route::get('/{id}', [
                    SellerController::class, "DetailSting"
                ]);
                Route::put('/revision/{id}', [
                    SellerController::class, "UploadRevision"
                ]);
                Route::put('/{id}', [
                    SellerController::class, "UploadFirstResult"
                ]);
            });
        });
        Route::get('/order', [
            SellerController::class, "Order"
        ]);
        Route::get('/order/accept/{id}', [
            SellerController::class, "AcceptOrder"
        ]);
        Route::get('/order/decline/{id}', [
            SellerController::class, "DeclineOrder"
        ]);
        Route::get('/report', [
            SellerController::class, "Report"
        ]);
        Route::post('/report', [
            SellerController::class, "GetReportData"
        ]);


        Route::get('/auction', [
            SellerController::class, "Auction"
        ]);
        Route::get('/auction/take/{id}', [
            SellerController::class, "TakeAuction"
        ]);
        Route::get('/auction/detail/revision/{id}', [
            SellerController::class, "RevisionAuction"
        ]);

        Route::put('/auction/detail/revision/{id}', [
            SellerController::class, "UploadRevisionAuction"
        ]);
        Route::get('/auction/detail/{id}', [
            SellerController::class, "DetailAuction"
        ]);
        Route::put('/auction/detail/{id}', [
            SellerController::class, "UploadFirstResultAuction"
        ]);
        Route::post('/auction/detail/chat/{id}', [
            BuyerController::class, "AddChat"
        ]);

        Route::get("/auction/detail/download/{name}", function ($name) {
            try {
                if (env("APP_ENV") == "production") {
                    // return Storage::download("order-deliver/$name", "hasil.jpg");
                    return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/".$name);
                } else {
                    return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
                    // return Storage::download("storage/order-deliver/$name", "hasil.jpg");
                    // return Storage::download("/public/order-deliver/$name", "hasil.jpg");
                }
            } catch (Exception) {
                return redirect("/seller/order")->with("error", "File not found");
            }
        });


        Route::prefix('profile')->group(function () {
            Route::get('/', [
                UserController::class, "Profile"
            ]);
            Route::get('/picture', [
                UserController::class, "PictureView" //buat ganti profile picture
            ]);
            Route::put('/picture', [
                UserController::class, "PictureUpdate" //buat ganti profile picture
            ]);
            Route::get('/password', [
                UserController::class, "ChangePasswordView"
            ]);
            Route::patch('/password', [
                UserController::class, "ChangePassword"
            ]);
            Route::patch('/', [
                UserController::class, "ProfileUpdate" //ini prosesnya
            ]);
        });
    });
    Route::prefix('buyer')->middleware("auth.role.buyer")->group(function () {
        Route::get('/', [
            //list sting
            BuyerController::class, "Home"
        ])->name("buyer");
        Route::prefix("topup")->group(function () {
            /**
             * TOP UP
             *
             */
            Route::get("/", [
                BuyerController::class, "TopUp"
            ]);
            Route::post("/pay", [
                TopUpController::class, "show"
            ]);
            Route::get("/success", function () {
                return redirect("/buyer/topup")->with("success", "Berhasil top up!");
            });
            Route::get("/failed", function () {
                return redirect("/buyer/topup")->with("error", "Top up gagal");
            });

            Route::get("/notify-ajax/{kode_topup}/success", [
                TopUpController::class, "finishPayment"
            ]);
            Route::get("/notify-ajax/{kode_topup}/failed", [
                TopUpController::class, "failedPayment"
            ]);
        });

        Route::prefix('sting')->group(function () {
            Route::get('/', [
                //list sting
                BuyerController::class, "ListSting"
            ])->name("BuyerSting");
            Route::post('/', [
                BuyerController::class, "FilterListSting"
            ])->name("BuyerFilterSting");
            Route::get('/category/{idCat}',[BuyerController::class, "ListStingCat"]);
            Route::get('/owner/{id}', [
                BuyerController::class, "OwnerStingView"
            ]);
            Route::get('/ordered', [
                //ordered sting
                BuyerController::class, "OrderedSting"
            ])->name("OrderedSting");

            Route::get('/ordered/cancel/{id}', [
                BuyerController::class, "CancelOrderedSting"
            ]);
            Route::get('/ordered/detail/{id}', [
                //ordered sting
                BuyerController::class, "DetailOrderedSting"
            ]);

            Route::post('/ordered/detail/decline/{id}', [
                BuyerController::class, "DeclineOrderedSting"
            ]);

            Route::post('/ordered/detail/chat/{id}', [
                BuyerController::class, "AddChat"
            ]);

            Route::get('/ordered/accept/{id}', [
                BuyerController::class, "RateReviewOrderedSting"
            ]);
            Route::post('/ordered/accept/{id}', [
                BuyerController::class, "CompleteSting"
            ]);

            Route::get("/ordered/detail/download/{name}", function ($name) {
                try {
                    if (env("APP_ENV") == "production") {
                        // return Storage::download("order-deliver/$name", "hasil.jpg");
                        return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/".$name);
                    } else {
                        return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
                        // return Storage::download("storage/order-deliver/$name", "hasil.jpg");
                        // return Storage::download("/public/order-deliver/$name", "hasil.jpg");
                    }
                } catch (Exception) {
                    return redirect("/seller/order")->with("error", "File not found");
                }
            });

            Route::get('/{kode}', [
                //buy sting
                BuyerController::class, "DetailSting"
            ])->name("DetailSting");
            Route::get('/{kode}/buy', [
                BuyerController::class, "BuyStingForm"
            ])->name("BuySting");
            Route::post('/{kode}/buy', [
                BuyerController::class, "BuySting"
            ]);
        });

        //AUCTION
        Route::prefix('auction')->group(function () {
            Route::get('/', [
                BuyerController::class, "Auction"
            ])->name("BuyerAuction");
            Route::get('/make', [
                BuyerController::class, "AuctionMake"
            ])->name("MakeAuction");
            Route::post('/make', [
                BuyerController::class, "AuctionMakeProcess"
            ]);
            Route::get('/cancel/{id}', [
                BuyerController::class, "CancelAuctionSting"
            ]);
            Route::get('/detail/{id}', [
                BuyerController::class, "DetailAuctionSting"
            ]);
            Route::post('/detail/chat/{id}', [
                BuyerController::class, "AddChat"
            ]);

            Route::post('/detail/decline/{id}', [
                BuyerController::class, "DeclineAuctionSting"
            ]);

            Route::get("/detail/download/{name}", function ($name) {
                try {
                    if (env("APP_ENV") == "production") {
                        // return Storage::download("order-deliver/$name", "hasil.jpg");
                        return redirect("https://mhs.sib.stts.edu/k3behive/order-deliver/".$name);
                    } else {
                        return response()->download(storage_path('/app/public/order-deliver/' . $name), "hasil.jpg");
                        // return Storage::download("storage/order-deliver/$name", "hasil.jpg");
                        // return Storage::download("/public/order-deliver/$name", "hasil.jpg");
                    }
                } catch (Exception) {
                    return redirect("/seller/order")->with("error", "File not found");
                }
            });

            Route::get('/accept/{id}', [
                BuyerController::class, "RateReviewAuction"
            ]);
            Route::post('/accept/{id}', [
                BuyerController::class, "CompleteAuction"
            ]);

        });
        Route::get('/report', [
            BuyerController::class, "ReportView"
        ]);
        Route::post('/report', [
            BuyerController::class, "GetReportData"
        ]);        //AUCTION TODO

        Route::prefix('profile')->group(function () {
            Route::get('/', [
                UserController::class, "Profile"
            ]);
            Route::get('/picture', [
                UserController::class, "PictureView" //buat ganti profile picture
            ]);
            Route::put('/picture', [
                UserController::class, "PictureUpdate" //buat ganti profile picture
            ]);
            Route::get('/password', [
                UserController::class, "ChangePasswordView"
            ]);
            Route::patch('/password', [
                UserController::class, "ChangePassword"
            ]);
            Route::patch('/', [
                UserController::class, "ProfileUpdate" //ini prosesnya
            ]);
        });
        Route::prefix("subscribe")->group(function () {
            Route::get("/", [
                BuyerController::class, "SuscribeIndexView"
            ]);
            Route::get("/confirm", [
                BuyerController::class, "SuscribeConfirmView"
            ]);
            Route::post("/confirm", [
                BuyerController::class, "SuscribeConfirm"
            ]);

            Route::get("/pay", [
                SubscribeController::class, "show"
            ]);

            Route::get("/success", function () {
                return redirect("/buyer/subscribe")->with("success", "Berhasil Upgrade Account!");
            });
            Route::get("/failed", function () {
                return redirect("/buyer/subscribe")->with("error", "Gagal Upgrade Account");
            });

            Route::get("/notify-ajax/{kode_topup}/success", [
                SubscribeController::class, "finishPayment"
            ]);
            Route::get("/notify-ajax/{kode_topup}/failed", [
                SubscribeController::class, "failedPayment"
            ]);
        });
    });
});

Route::get("/logout", [
    UserController::class, "LogOut"
]);

Route::get('/randid', function () {
    dump(UserController::GenerateRandomToken(30));
});
Route::get('/tespage', function () {
    return view("userAuth.tes");
});

Route::get('/artisan/link', function () {
    Artisan::call('storage:link');
    return redirect("/")->with("success", "Link storage success");
});
Route::get('artisan/clear', function () {
    Artisan::call('cache:clear');
    return redirect("/")->with("success", "Cache clear success");
});

Route::get('/artisan/migrate', function () {
    Artisan::call('migrate:fresh', [
        '--force' => true
    ]);
    return redirect("/")->with("success", "Migrate success");
});
Route::get('/artisan/seed', function () {
    Artisan::call('db:seed', [
        '--force' => true
    ]);
    return redirect("/")->with("success", "Seeding success");
});
