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

class FarmerLelangStingController extends Controller
{
    public function FetchLelangSting(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("EMAIL_FARMER", $user->EMAIL)->get();

        foreach ($lelang as $key => $value) {
            $revisionLeft = 2;
            $statusString = "";

            if ($value->STATUS == -1) {
                $statusString = 'Deleted';
            } elseif ($value->STATUS == 0) {
                $statusString = 'Pending';
            } elseif ($value->STATUS == 1) {
                $statusString = 'In Progress';
            } elseif ($value->STATUS == 2) {
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

            $complains = StingComplainResolve::where("ID_TRANSACTION", $value->ID_LELANG_STING)->where("TYPE", 1)->get();
            //get type lelang sting

            $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $value->ID_LELANG_STING)->where("TYPE", 1)
                ->where("FILE_REVISION", "<>", "")->get();
            $revisionLeft -= sizeof($revisionDone);


            $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $value->ID_LELANG_STING)->where("TYPE", 1)
                ->where("FILE_REVISION", "")->get());

            $lelang[$key]->statusString = $statusString;
            $lelang[$key]->complains = $complains;
            $lelang[$key]->revisionLeft = $revisionLeft;
            $lelang[$key]->revisionWaiting = $revisionWaiting;
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Fetch lelang Sting Success',
            'data'      => $lelang
        ], 200);
    }
    public function GetLelangSting(Request $request, $id)
    {

        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)->get()->first();

        if ($lelang == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Lelang Sting tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $orderDate = Carbon::parse($lelang->CREATED_AT)->format('d F Y');
        $acceptedDate = Carbon::parse($lelang->DATE_START)->format('d F Y');
        $revisionLeft = 2;
        $statusString = "";


        if ($lelang->STATUS == -1) {
            $statusString = 'Deleted';
        } elseif ($lelang->STATUS == 0) {
            $statusString = 'Pending';
        } elseif ($lelang->STATUS == 1) {
            $statusString = 'In Progress';
        } elseif ($lelang->STATUS == 2) {
            $statusString = 'Selesai';
        } else {
            $statusString = 'Unknown';
        }
        $waiting = false;
        //beri pengecekkan kalo sedang disubmit dan nunggu approve
        if ($lelang->FILENAME_FINAL != "" && $lelang->STATUS == 1) {
            $statusString = "Waiting Approval";
            $waiting = true;
        }

        $complains = StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)->get();
        //get type lelang sting

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "<>", "")->get();
        $revisionLeft -= sizeof($revisionDone);


        $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "")->get());

        $lelang->statusString = $statusString;
        $lelang->complains = $complains;
        $lelang->revisionLeft = $revisionLeft;
        $lelang->revisionWaiting = $revisionWaiting;


        return response()->json([
            'success'   => true,
            'message'   => 'Get lelang Sting Success',
            'data'      => $lelang
        ], 200);
    }
    public function AuctionMakeProcess(Request $request)
    {
        //request input needed title, requirement, price, category
        if (
            $request->input("title") == null ||
            $request->input("requirement") == null ||
            $request->input("price") == null ||
            $request->input("category") == null ||
            $request->input("title") == "" ||
            $request->input("requirement") == "" ||
            $request->input("price") == "" ||
            $request->input("category") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request',
                'data'      =>  "{}"
            ], 400);
        }
        $rules = [
            'category' => ["required"]
        ];
        $messages = [
            "category.required" => "Anda harus memilih kategori",
        ];
        $request->validate($rules, $messages);

        $title = $request->input("title");
        $requirement = $request->input("requirement");
        $price = $request->input("price");
        $category = $request->input("category");

        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();


        $newkey =  UserControllerAPI::GenerateRandomToken(7);
        $kode = "L_" . $newkey;
        $lelang = new LelangSting();
        $lelang->ID_LELANG_STING = $kode;
        $lelang->REQUIREMENT_PROJECT = $requirement;
        $lelang->TITLE_STING = $title;
        $lelang->COMMISION = $price * 90 / 100;
        $lelang->TAX = $price * 10 / 100;
        $lelang->FILENAME_FINAL = "";
        $lelang->STATUS = 0;
        $lelang->EMAIL_FARMER = $user->EMAIL;
        $lelang->RATE = 0;
        $lelang->REVIEW = "";
        $lelang->save();


        $newC = new LelangStingCategory();
        $newC->ID_LELANG_STING = $kode;
        $newC->ID_CATEGORY = $category;
        $newC->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil membuat lelang sting!',
            'data'      =>  "{}"
        ], 201);
    }

    public function CancelLelangSting(Request $request, $id)
    {

        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)->get()->first();

        if ($lelang == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Lelang Sting tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }
        if ($lelang->STATUS != 0) {
            return response()->json([
                'success'   => false,
                'message'   => 'Lelang ini tidak dalam keadaan pending',
                'data'      =>  "{}"
            ], 403);
        }
        $lelang->STATUS = -1; //ubah ke status deleted
        $lelang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Berhasil delete sting",
            'data'      =>  "{}"
        ], 201);
    }
    public function FetchComplainLelangSting(Request $request, $id)
    {

        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)->get()->first();


        $complains = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)
            ->where("TYPE", 1)->get();


        return response()->json([
            'success'   => true,
            'message'   => 'Fetch complain success!',
            'data'      =>  $complains
        ], 201);
    }

    public function DeclineLelangSting(Request $request, $id)
    {
        //input needed complain
        //path needed id
        if (
            $request->input("complain") == null ||
            $request->input("complain") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 2)
            ->get()->first();

        if ($lelang == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Lelang Sting tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $revisionLeft = 2;

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
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
        $complain->TYPE = 1;
        $complain->FILE_REVISION = "";
        $complain->save();

        return response()->json([
            'success'   => true,
            'message'   => "Berhasil Decline Lelang Submission dan Mengirim Complain",
            'data'      =>  "{}"
        ], 201);
    }
    public function CompleteLelangSting(Request $request, $id)
    {
        //input needed rating and review
        //path needed id
        if (
            $request->input("rating") == null ||
            $request->input("rating") == "" ||
            $request->input("review") == null ||
            $request->input("review") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $rating = $request->input("rating");
        $review = $request->input("review");
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 2)
            ->get()->first();

        if ($lelang == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Lelang Sting tidak ditemukan',
                'data'      =>  "{}"
            ], 404);
        }

        $lelang->RATE = $rating;
        $lelang->REVIEW = $review;
        $lelang->STATUS = 2;
        $lelang->save();

        //update beeworker
        $emailBeeworker = $lelang->beeworker->EMAIL;
        $userUpd = User::where("EMAIL", $emailBeeworker)->get()->first();
        $userUpd->BALANCE += $lelang->COMMISION;
        $userUpd->save();

        return response()->json([
            'success'   => true,
            'message'   => "Berhasil finish lelang sting!",
            'data'      =>  "{}"
        ], 201);
    }
}
