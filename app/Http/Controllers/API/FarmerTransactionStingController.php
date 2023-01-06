<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LelangSting;
use App\Models\LelangStingCategory;
use App\Models\Sting;
use App\Models\StingComplainResolve;
use App\Models\TransactionSting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FarmerTransactionStingController extends Controller
{

    public function FetchTransactionSting(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $transaction = TransactionSting::with("sting")
            ->where("EMAIL_FARMER", $user->EMAIL)->get();

            foreach ($transaction as $key => $value) {
                //adding detail
                $isPremium = $value->IS_PREMIUM == 1 ? true : false;
                $orderDate = Carbon::parse($value->CREATED_AT)->format('d F Y');
                $acceptedDate = Carbon::parse($value->DATE_START)->format('d F Y');
                $revisionLeft = $isPremium ? $value->sting->MAX_REVISION_PREMIUM : $value->sting->MAX_REVISION_BASIC;
                $author = $value->sting->author;
                if ($value->STATUS == -2) {
                    $statusString = 'Canceled';
                } elseif ($value->STATUS == -1) {
                    $statusString = 'Rejected';
                } elseif ($value->STATUS == 0) {
                    $statusString = 'Pending';
                } elseif ($value->STATUS == 1) {
                    $statusString = 'In Progress';
                } elseif ($value->STATUS == 2) {
                    $statusString = 'In Revision';
                } elseif ($value->STATUS == 3) {
                    $statusString = 'Selesai';
                } else {
                    $statusString = 'Unknown';
                }
                $waiting = false;
                //beri pengecekkan kalo sedang disubmit dan nunggu approve
                if ($value->FILENAME_FINAL != "" && $value->STATUS == 1) {
                    $statusString = "Waiting Approval";
                    $waiting = true;
                }

                $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $value->ID_TRANSACTION)->where("TYPE", 0)
                    ->where("FILE_REVISION", "<>", "")->get();

                $revisionLeft -= sizeof($revisionDone);

                $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $value->ID_TRANSACTION)
                ->where("TYPE", 0)->where("FILE_REVISION", "")->get());

                $complains = StingComplainResolve::orderBy("CREATED_AT", "DESC")
                    ->where("ID_TRANSACTION", $value->ID_TRANSACTION)
                    ->where("TYPE", 0)->get();

                $transaction[$key]->statusString = $statusString;
                $transaction[$key]->complains = $complains;
                $transaction[$key]->revisionLeft = $revisionLeft;
                $transaction[$key]->revisionWaiting = $revisionWaiting;
                $transaction[$key]->sting->author = $author;
            }
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Transaction Sting Success',
            'data'      => $transaction
        ], 200);
    }
    public function FetchTransactionStingByStatus(Request $request, $status)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $transaction = TransactionSting::with("sting")
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", $status)->get();
        foreach ($transaction as $key => $value) {
            //adding detail
            $isPremium = $value->IS_PREMIUM == 1 ? true : false;
            $orderDate = Carbon::parse($value->CREATED_AT)->format('d F Y');
            $acceptedDate = Carbon::parse($value->DATE_START)->format('d F Y');
            $revisionLeft = $isPremium ? $value->sting->MAX_REVISION_PREMIUM : $value->sting->MAX_REVISION_BASIC;
            $author = $value->sting->author;
            if ($value->STATUS == -2) {
                $statusString = 'Canceled';
            } elseif ($value->STATUS == -1) {
                $statusString = 'Rejected';
            } elseif ($value->STATUS == 0) {
                $statusString = 'Pending';
            } elseif ($value->STATUS == 1) {
                $statusString = 'In Progress';
            } elseif ($value->STATUS == 2) {
                $statusString = 'In Revision';
            } elseif ($value->STATUS == 3) {
                $statusString = 'Selesai';
            } else {
                $statusString = 'Unknown';
            }
            $waiting = false;
            //beri pengecekkan kalo sedang disubmit dan nunggu approve
            if ($value->FILENAME_FINAL != "" && $value->STATUS == 1) {
                $statusString = "Waiting Approval";
                $waiting = true;
            }

            $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $value->ID_TRANSACTION)->where("TYPE", 0)
                ->where("FILE_REVISION", "<>", "")->get();

            $revisionLeft -= sizeof($revisionDone);

            $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $value->ID_TRANSACTION)
            ->where("TYPE", 0)->where("FILE_REVISION", "")->get());

            $complains = StingComplainResolve::orderBy("CREATED_AT", "DESC")
                ->where("ID_TRANSACTION", $value->ID_TRANSACTION)
                ->where("TYPE", 0)->get();

            $transaction[$key]->statusString = $statusString;
            $transaction[$key]->complains = $complains;
            $transaction[$key]->revisionLeft = $revisionLeft;
            $transaction[$key]->revisionWaiting = $revisionWaiting;
            $transaction[$key]->sting->author = $author;
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Transaction Sting By Status Success',
            'data'      => $transaction
        ], 200);
    }
    public function  GetTransactionSting(Request $request, $id)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();

        if ($order == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $isPremium = $order->IS_PREMIUM == 1 ? true : false;
        $orderDate = Carbon::parse($order->CREATED_AT)->format('d F Y');
        $acceptedDate = Carbon::parse($order->DATE_START)->format('d F Y');
        $revisionLeft = $isPremium ? $order->sting->MAX_REVISION_PREMIUM : $order->sting->MAX_REVISION_BASIC;
        $author = $order->sting->author;
        if ($order->STATUS == -2) {
            $statusString = 'Canceled';
        } elseif ($order->STATUS == -1) {
            $statusString = 'Rejected';
        } elseif ($order->STATUS == 0) {
            $statusString = 'Pending';
        } elseif ($order->STATUS == 1) {
            $statusString = 'In Progress';
        } elseif ($order->STATUS == 2) {
            $statusString = 'In Revision';
        } elseif ($order->STATUS == 3) {
            $statusString = 'Selesai';
        } else {
            $statusString = 'Unknown';
        }
        $waiting = false;
        //beri pengecekkan kalo sedang disubmit dan nunggu approve
        if ($order->FILENAME_FINAL != "" && $order->STATUS == 1) {
            $statusString = "Waiting Approval";
            $waiting = true;
        }

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "<>", "")->get();

        $revisionLeft -= sizeof($revisionDone);

        $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "")->get());

        $complains = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)
            ->where("TYPE", 0)->get();

        $order->statusString = $statusString;
        $order->complains = $complains;
        $order->revisionLeft = $revisionLeft;
        $order->revisionWaiting = $revisionWaiting;

        return response()->json([
            'success'   => true,
            'message'   => 'Get Detail Transaction Sting Success!',
            'data'      =>  $order
        ], 201);
    }

    public function  DeclineTransactionSting(Request $request, $id)
    {
        //request needed -> REMEMBER_TOKEN
        //INPUT -> complain
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 3)
            ->get()->first();

        if ($order == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $isPremium = $order->IS_PREMIUM == 1 ? true : false;
        $revisionLeft = $isPremium ? $order->sting->MAX_REVISION_PREMIUM : $order->sting->MAX_REVISION_BASIC;

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "<>", "")->get();

        $revisionLeft -= sizeof($revisionDone);

        if ($revisionLeft < 1) {
            return response()->json([
                'success'   => false,
                'message'   => 'Batas revisi sudah mencapai maksimum',
                'data'      =>  "{}"
            ], 403);
        }

        $complain = new StingComplainResolve();
        $complain->ID_TRANSACTION = $id;
        $complain->COMPLAIN = $request->input("complain");
        $complain->TYPE = 0;
        $complain->FILE_REVISION = "";
        $complain->save();

        $order->STATUS = 2;
        $order->save();
        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Decline Order dan Mengirim Complain',
            'data'      =>  "{}"
        ], 201);
    }

    public function CompleteTransactionSting(Request $request, $id)
    {
        //REQUEST INPUT NEEDED rating, review
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)
                ->get()->first();
        $rating = $request->input("rating");
        $review = $request->input("review");
        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 3)
            ->get()->first();
        if ($order == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }
        $order->RATE = $rating;
        $order->REVIEW = $review;
        $order->STATUS = 3;
        $order->save();

        $emailBeeworker = $order->sting->author->EMAIL;
        $userUpd = User::where("EMAIL", $emailBeeworker)->get()->first();
        $userUpd->BALANCE += $order->COMMISION;
        $userUpd->save();


        $jumlahPemberiRating = sizeof(
            TransactionSting::where("ID_STING", $order->ID_STING)
                ->where("REVIEW", "<>", "")->get()
        );

        $totalRating = DB::select(
            'select sum(RATE) as jumlah from transaction_sting where ID_STING = ? and REVIEW <> "" ',
            [$order->ID_STING]
        );

        //ini untuk update sting rating
        $rating = $totalRating[array_key_first($totalRating)]->jumlah;
        $rating /= $jumlahPemberiRating;

        $stingUpd = Sting::where("ID_STING", $order->ID_STING)->get()->first();
        $stingUpd->RATING = $rating;
        $stingUpd->save();

        //Berhasil finish order!
        return response()->json([
            'success'   => true,
            'message'   => "Berhasil Finish Order",
            'data'      =>  "{}"
        ], 201);
    }
    public function BuySting(Request $request, $kode, $mode)
    {
        //req input = REQUIREMENT_PROJECT
        //req REMEMBER_TOKEN,
        //url param kode, mode premium atau basic
        if ($request->input("REQUIREMENT_PROJECT") == null) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request, requirement project not found',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $sting = Sting::with("author")->find($kode);
        $mode = strtolower($mode);


        $cekUang = $mode == "premium" ? $sting->PRICE_PREMIUM : $sting->PRICE_BASIC;
        if ($cekUang > $user->BALANCE) {
            return response()->json([
                'success'   => false,
                'message'   => 'Credit anda tidak cukup',
                'data'      =>  "{}"
            ], 412);
        }
        $cekSudahPesan = TransactionSting::where("ID_STING", $sting->ID_STING)
            ->where("EMAIL_FARMER", $user->EMAIL)->where("STATUS", ">", -1)
            ->where("STATUS", "<", 3) //ini cek apa sting sedang dipesan (statusnya pending - revisi)
            ->get()->first();
        if ($cekSudahPesan != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Anda sedang memesan sting ini!',
                'data'      =>  "{}"
            ], 409);
        }
        $rand = UserControllerAPI::GenerateRandomToken(7);
        $newKode = "T_" . $rand;
        $newTrans = new TransactionSting();
        $newTrans->ID_TRANSACTION = $newKode;
        $newTrans->ID_STING = $sting->ID_STING;
        $newTrans->EMAIL_FARMER = $user->EMAIL;
        $newTrans->STATUS = 1; //lgsg dianggap terima
        $newTrans->REQUIREMENT_PROJECT = $request->input("REQUIREMENT_PROJECT");
        if ($mode == "premium") {
            $newTrans->IS_PREMIUM = 1;
            $newTrans->JUMLAH_REVISI = $sting->MAX_REVISION_PREMIUM;
            $newTrans->COMMISION = $sting->PRICE_PREMIUM * 90 / 100;
            $newTrans->TAX = $sting->PRICE_PREMIUM * 10 / 100;

            $userU = User::where("EMAIL", $user->EMAIL)->get()->first();
            $userU->BALANCE -= $sting->PRICE_PREMIUM;
            $userU->save();
        } else {
            $newTrans->IS_PREMIUM = 0;
            $newTrans->JUMLAH_REVISI = $sting->MAX_REVISION_BASIC;
            $newTrans->COMMISION = $sting->PRICE_BASIC * 90 / 100;
            $newTrans->TAX = $sting->PRICE_BASIC * 10 / 100;

            $userU = User::where("EMAIL", $user->EMAIL)->get()->first();
            $userU->BALANCE -= $sting->PRICE_BASIC;
            $userU->save();
        }
        $newTrans->FILENAME_FINAL = "";
        $newTrans->RATE = 0;
        $newTrans->REVIEW = "";
        $newTrans->save();

        // 'message'   => 'Berhasil membuat order sting!',
        return response()->json([
            'success'   => true,
            'message'   => $userU->BALANCE,
            'data'      =>  "{}"
        ], 201);
    }
    public function  CancelTransactionSting(Request $request, $id)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();

        if ($order == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }
        if ($order->STATUS != 0) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order ini tidak dalam keadaan pending',
                'data'      =>  "{}"
            ], 403);
        }
        $order->STATUS = -2; //ubah ke status canceled
        $order->save();

        return response()->json([
            'success'   => true,
            'message'   => "Berhasil cancel order sting",
            'data'      =>  "{}"
        ], 201);
    }
    public function  FetchComplainTransactionSting(Request $request, $id)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();

        if ($order == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $complains = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)
            ->where("TYPE", 0)->get();


        return response()->json([
            'success'   => true,
            'message'   => 'Fetch complain success!',
            'data'      =>  $complains
        ], 201);
    }
}
