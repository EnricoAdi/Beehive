<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FrontEnd\RouteController;
use App\Http\Controllers\FrontEnd\UserController;
use App\Models\TopUp;
use App\Models\User;
use App\Services\Midtrans\CallbackService;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function getRole($status)
    {
        $role = "";
        if ($status == 1) {
            $role = "Buyer";
        }
        if ($status == 2) {
            $role = "Seller";
        }
        if ($status == 3) {
            $role = "Admin";
        }
        if ($status == 0) {
            $role = "Not Verified";
        }
        return [$status, $role];
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        $role = $this->getRole($user->STATUS);

        $route = RouteController::getRouteArray();

        $credit = $request->input("CREDIT");
        $kodeTopUp = UserController::GenerateRandomToken(30);
        $topup = new TopUp();
        $topup->KODE_TOPUP = $kodeTopUp;
        $topup->EMAIL = $user->EMAIL;
        $topup->CREDIT = $credit;
        $topup->PAYMENT_STATUS = 0;

        $midtrans = new CreateSnapTokenService($topup);
        $snapToken = $midtrans->getSnapToken("Top Up");

        $topup->SNAP_TOKEN = $snapToken;
        $topup->save();

        return view('Buyer.TopUp.show', compact('topup','kodeTopUp', 'snapToken','role','user','route','credit'));
    }

    public function finishPayment($kode_topup){
        $topup = TopUp::where('KODE_TOPUP', $kode_topup)->get()->first();
        TopUp::where('KODE_TOPUP', $kode_topup)->update([
            'PAYMENT_STATUS' => 1,
        ]);
        $user = User::where("EMAIL",$topup->EMAIL)->get()->first();
        if($user!=null){
            $user->BALANCE+= $topup->CREDIT;
            $user->save();

            // UPDATE USER YANG LAGI LOGIN
            Auth::login($user);
        }
        return response("",200);
    }
    public function failedPayment($kode_topup){
        TopUp::where('KODE_TOPUP', $kode_topup)->update([
            'PAYMENT_STATUS' => -1,
        ]);
        return response("",200);
    }
    // public function receive()
    // {
    //     $callback = new CallbackService;

    //     if ($callback->isSignatureKeyVerified()) {
    //         $notification = $callback->getNotification();
    //         $order = $callback->getOrder();

    //         if ($callback->isSuccess()) {
    //             TopUp::where('KODE_TOPUP', $order->KODE_TOPUP)->update([
    //                 'PAYMENT_STATUS' => 1,
    //             ]);
    //         }

    //         if ($callback->isExpire()) {
    //             TopUp::where('KODE_TOPUP', $order->KODE_TOPUP)->update([
    //                 'PAYMENT_STATUS' => -1,
    //             ]);
    //         }

    //         if ($callback->isCancelled()) {
    //             TopUp::where('KODE_TOPUP', $order->KODE_TOPUP)->update([
    //                 'PAYMENT_STATUS' => -1,
    //             ]);
    //         }

    //         return response()
    //             ->json([
    //                 'success' => true,
    //                 'message' => 'Notifikasi berhasil diproses',
    //             ]);
    //     } else {
    //         return response()
    //             ->json([
    //                 'error' => true,
    //                 'message' => 'Signature key tidak terverifikasi',
    //             ], 403);
    //     }
    // }
}
