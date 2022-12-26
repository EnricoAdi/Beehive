<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LelangSting;
use App\Models\LelangStingCategory;
use App\Models\Sting;
use App\Models\TransactionSting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FarmerControllerAPI extends Controller
{
    public function FetchCategory(Request $request)
    {
        $categories = Category::all();
        foreach ($categories as $key => $value) {
            $categories[$key]->stingsRelatedCount = sizeof($value->stingsRelated);
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Category Success',
            'data'      => $categories
        ], 200);
    }
    public function FetchSting(Request $request)
    {
        $stings = Sting::all();
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Sting Success',
            'data'      => $stings
        ], 200);
    }
    public function FetchTransactionSting(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $transaction = TransactionSting::where("EMAIL_FARMER", $user->EMAIL)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Transaction Sting Success',
            'data'      => $transaction
        ], 200);
    }
    public function FetchLelangSting(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $lelang = LelangSting::where("EMAIL_FARMER", $user->EMAIL)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Fetch lelang Sting Success',
            'data'      => $lelang
        ], 200);
    }
    public function MostOrderedStingThisMonth(Request $request)
    {

        $IDSting = DB::select('SELECT t.ID_STING, COUNT(*) FROM
        transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING
            GROUP BY t.ID_STING
            ORDER BY 2 DESC');

        if ($IDSting == null || $IDSting == "" || $IDSting == []) {
            return response()->json([
                'success'   => false,
                'message'   => 'No Sting Purchased',
                'data'      => "{}"
            ], 404);
        }
        $mostBought = Sting::where("ID_STING", $IDSting[0]->ID_STING)
            ->get()->first();


        return response()->json([
            'success'   => true,
            'message'   => 'Get Most Ordered Sting Success',
            'data'      => $mostBought
        ], 200);
    }

    public function FetchStingByCategory(Request $request, $category)
    {
        //request needed = category (id category)
        $idCategory = $category;
        if ($idCategory == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Category not found',
                'data'      => "{}"
            ], 400);
        }
        $stings = DB::select(
            "
        select s.*, u.NAMA as NAMA_BEEWORKER, u.PICTURE as PICTURE_BEEWORKER
        from sting s join sting_category sc on s.ID_STING = sc.ID_STING
        join user u on u.EMAIL = s.EMAIL_BEEWORKER
        where sc.ID_CATEGORY=?",
            [$idCategory]
        );


        foreach ($stings as $key => $value) {
            $jumlahOrder = DB::select("
            select count(*) as JUMLAH_ORDER from transaction_sting t join sting s on
            t.ID_STING = s.ID_STING where t.RATE>0 and s.ID_STING = ?", [
                $value->ID_STING
            ]);
            $stings[$key]->JUMLAH_ORDER = $jumlahOrder[0]->JUMLAH_ORDER;
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Fetch Success',
            'data'      => $stings
        ], 200);
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

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil membuat order sting!',
            'data'      =>  $userU //ngirim data user yang baru
        ], 201);
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

        // $categories = explode(',', $request->input('category'));
        // if (end($categories) == "") {
        //     array_pop($categories);
        // }

        // foreach ($categories as $c) {
        //     $sting_category = Category::where("NAMA_CATEGORY", "LIKE", "%$c%")->get()->first();
        //     if ($sting_category != null) {
        //         $newC = new LelangStingCategory();
        //         $newC->ID_LELANG_STING = $kode;
        //         $newC->ID_CATEGORY = $sting_category->ID_CATEGORY;
        //         $newC->save();
        //     }
        // }

        // $sting_category = Category::where("NAMA_CATEGORY", "LIKE", "%$$category%")->get()->first();
        // if ($sting_category != null) {
        //     $newC = new LelangStingCategory();
        //     $newC->ID_LELANG_STING = $kode;
        //     // $newC->ID_CATEGORY = $sting_category->ID_CATEGORY;
        //     $newC->ID_CATEGORY = $category;
        //     $newC->save();
        // }

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
}
