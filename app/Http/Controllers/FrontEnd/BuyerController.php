<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChatSting;
use App\Models\LelangSting;
use App\Models\LelangStingCategory;
use App\Models\Sting;
use App\Models\StingCategory;
use App\Models\StingComplainResolve;
use App\Models\StingMedia;
use App\Models\TopUp;
use App\Models\TransactionSting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BuyerController extends Controller
{
    public function getRole($status)
    {
        //function ini untuk mereturn role dalam string
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
    public function Home()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);

        $route = RouteController::getRouteArray();
        //sg lagi dibeli
        //rekomendasi dari pembelian terakhir
        //list category

        $categories = Category::all();
        $listSting = Sting::orderBy('RATING', 'DESC')->take(4)->get();

        $onGoing = TransactionSting::orderBy("CREATED_AT", "desc")->where("EMAIL_FARMER", $user->EMAIL)->where('STATUS', 1)->get()->first() ?? null;
        // dd($ordered);

        $categories = Category::all();

        return view("Buyer.home", compact("role", "route", "user", "onGoing", "listSting"));
    }

    public function TopUp()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);

        $route = RouteController::getRouteArray();
        $listTopup = TopUp::where("EMAIL", "=", $user->EMAIL)->where("PAYMENT_STATUS", "=", 1)->paginate(15);
        return view("Buyer.TopUp.index", compact("role", "route", "user", "listTopup"));
    }
    public function ListSting()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $listSting = Sting::with("author")->where("status", "=", 1)->get();
        // dd($listSting);
        return view("Buyer.sting.list", compact("role", "route", "user", "listSting"));
    }
    public function FilterListSting(Request $req)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        // $category = $req->category;
        $nama = $req->nama;
        $listSting = [];

        if ($nama == "" || $nama == null) {
            $listSting = Sting::with("author")->where("status", "=", 1)->get();
        } else {
            $listSting = Sting::with("author")->where("status", "=", 1)
                ->where("TITLE_STING", "LIKE", "%" . $nama . "%")->get();
        }


        return view("Buyer.sting.list", compact("role", "route", "user", "listSting"));
    }
    public function ListStingCat($idCat)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $arrID = StingCategory::where('ID_CATEGORY', $idCat)->get('ID_STING');

        // dump($arrID);

        $listSting = [];

        foreach ($arrID as $key => $id) {
            // dump($id->ID_STING);
            $listSting[] = Sting::where('ID_STING', $id->ID_STING)->get()->first();
        }

        // dd($listSting);

        // $listSting = Sting::with("author")->where("status", "=", 1)->get();
        // dd($listSting);

        return view("Buyer.sting.list", compact("role", "route", "user", "listSting"));
    }
    public function Profile()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        return view("Buyer.profile", compact("role", "route", "user"));
    }
    public function DetailSting(Request $req, $kode)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $sting = Sting::with("author")->find($kode);
        $id = $kode;
        $foto = StingMedia::where("ID_STING", "=", $kode)->get("FILENAME");
        return view("Buyer.sting.detail", compact("role", "id", "route", "user", "sting", "kode", "foto"));
    }
    public function BuyStingForm(Request $req, $kode)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $sting = Sting::with("author")->find($kode);
        $mode = $req->mode;
        $cek = strtolower($mode);
        if ($cek != "premium" && $cek != "basic") {
            return redirect("/buyer/sting")->with("error", "Mode tidak sesuai");
        }
        return view("Buyer.sting.buy", compact("role", "route", "user", "sting", "kode", "mode"));
    }

    public function BuySting(Request $request, $kode)
    {
        $user = Auth::user();
        $sting = Sting::with("author")->find($kode);
        $mode = strtolower($request->mode);

        $cekUang = $mode == "premium" ? $sting->PRICE_PREMIUM : $sting->PRICE_BASIC;
        if ($cekUang > $user->BALANCE) {
            return redirect("/buyer/sting")->with("error", "Saldo anda tidak cukup!");
        }
        $cekSudahPesan = TransactionSting::where("ID_STING", $sting->ID_STING)
            ->where("EMAIL_FARMER", $user->EMAIL)->where("STATUS", ">", -1)
            ->where("STATUS", "<", 3) //ini cek apa sting sedang dipesan (statusnya pending - revisi)
            ->get()->first();
        if ($cekSudahPesan != null) {
            return redirect("/buyer/sting")->with("error", "Anda sedang memesan sting ini!");
        }
        $rand = UserController::GenerateRandomToken(7);
        $newKode = "T_" . $rand;
        $newTrans = new TransactionSting();
        $newTrans->ID_TRANSACTION = $newKode;
        $newTrans->ID_STING = $sting->ID_STING;
        $newTrans->EMAIL_FARMER = $user->EMAIL;
        $newTrans->STATUS = 0;
        $newTrans->REQUIREMENT_PROJECT = $request->input("REQUIREMENT_PROJECT");
        if ($mode == "premium") {
            $newTrans->IS_PREMIUM = 1;
            $newTrans->JUMLAH_REVISI = $sting->MAX_REVISION_PREMIUM;
            $newTrans->COMMISION = $sting->PRICE_PREMIUM * 90 / 100;
            $newTrans->TAX = $sting->PRICE_PREMIUM * 10 / 100;

            $userU = User::where("EMAIL", $user->EMAIL)->get()->first();
            $userU->BALANCE -= $sting->PRICE_PREMIUM;
            $userU->save();
            Auth::login($userU);
        } else {
            $newTrans->IS_PREMIUM = 0;
            $newTrans->JUMLAH_REVISI = $sting->MAX_REVISION_BASIC;
            $newTrans->COMMISION = $sting->PRICE_BASIC * 90 / 100;
            $newTrans->TAX = $sting->PRICE_BASIC * 10 / 100;

            $userU = User::where("EMAIL", $user->EMAIL)->get()->first();
            $userU->BALANCE -= $sting->PRICE_BASIC;
            $userU->save();
            Auth::login($userU);
        }
        $newTrans->FILENAME_FINAL = "";
        $newTrans->RATE = 0;
        $newTrans->REVIEW = "";
        $newTrans->save();



        return redirect("/buyer/sting")->with("success", "Berhasil membuat order sting!");
    }
    public function OrderedSting()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $ordered = TransactionSting::with("sting")->orderBy("CREATED_AT", "desc")->where("EMAIL_FARMER", $user->EMAIL)->get();
        return view("Buyer.sting.ordered", compact("role", "route", "user", "ordered"));
    }
    public function DetailOrderedSting(Request $request, $id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();
        if ($order == null) {
            return redirect("/buyer/sting/ordered")->with("error", "Order tidak ditemukan");
        }

        $isPremium = $order->IS_PREMIUM == 1 ? true : false;
        $orderDate = Carbon::parse($order->CREATED_AT)->format('d F Y');
        $acceptedDate = Carbon::parse($order->DATE_START)->format('d F Y');
        $revisionLeft = $isPremium ? $order->sting->MAX_REVISION_PREMIUM : $order->sting->MAX_REVISION_BASIC;


        if ($order->STATUS == -2) {
            $statusColor = 'text-red-700';
            $status = 'Canceled';
        } elseif ($order->STATUS == -1) {
            $status = 'Rejected';
            $statusColor = 'text-red-600';
        } elseif ($order->STATUS == 0) {
            $status = 'Pending';
            $statusColor = 'text-yellow-400';
        } elseif ($order->STATUS == 1) {
            $status = 'In Progress';
            $statusColor = 'text-amber-800';
        } elseif ($order->STATUS == 2) {
            $status = 'In Revision';
            $statusColor = 'text-blue-800';
        } elseif ($order->STATUS == 3) {
            $status = 'Selesai';
            $statusColor = 'text-primary';
        } else {
            $status = 'Unknown';
        }
        $waiting = false;
        //beri pengecekkan kalo sedang disubmit dan nunggu approve
        if ($order->FILENAME_FINAL != "" && $order->STATUS == 1) {
            $status = "Waiting Approval";
            $waiting = true;
        }

        $complains = StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)->get();

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "<>", "")->get();

        $revisionLeft -= sizeof($revisionDone);

        $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "")->get());

        $chats = ChatSting::where("ID_TRANSACTION", $id)->get();
        return view(
            "Buyer.sting.ordered.detail",
            compact(
                "role",
                "route",
                "user",
                "order",
                "orderDate",
                "acceptedDate",
                "revisionLeft",
                "revisionWaiting",
                "isPremium",
                "status",
                "statusColor",
                "waiting",
                "complains",
                "id",
                "chats"
            )
        );
    }

    public function RateReviewOrderedSting(Request $request, $id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();
        if ($order == null) {
            return redirect("/buyer/sting/ordered")->with("error", "Order tidak ditemukan");
        }

        return view(
            "Buyer.sting.ordered.review",
            compact(
                "role",
                "route",
                "user",
                "order",
                "id"
            )
        );
    }
    public function DeclineOrderedSting(Request $request, $id)
    {

        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 3)
            ->get()->first();
        if ($order == null) {
            return redirect("/buyer/sting/ordered")->with("error", "Order tidak ditemukan");
        }
        $isPremium = $order->IS_PREMIUM == 1 ? true : false;
        $revisionLeft = $isPremium ? $order->sting->MAX_REVISION_PREMIUM : $order->sting->MAX_REVISION_BASIC;

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "<>", "")->get();

        $revisionLeft -= sizeof($revisionDone);

        if ($revisionLeft < 1) {
            return redirect("/buyer/sting/ordered/detail/$id")->with("error", "Batas revisi sudah mencapai maksimum");
        }

        $complain = new StingComplainResolve();
        $complain->ID_TRANSACTION = $id;
        $complain->COMPLAIN = $request->input("complain");
        $complain->TYPE = 0;
        $complain->FILE_REVISION = "";
        $complain->save();

        $order->STATUS = 2;
        $order->save();
        return redirect()->back()->with("success", "Berhasil Decline Order dan Mengirim Complain");
    }

    public function ReportView()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $listTopup = [];
        $totalTopup = 0;
        return view("Buyer.report.report", compact("role", "route", "user", "listTopup", "totalTopup"));
    }

    public function GetReportData(Request $req)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $req->validate([
            "tgl1" => "required",
            "tgl2" => "required",
        ]);

        $tgl1 = $req->tgl1;
        $tgl2 = $req->tgl2;

        if ($tgl1 > $tgl2) {
            return redirect()->back()->with("error", "Tanggal awal harus lebih awal!");
        }

        $listTopup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)
            ->where("EMAIL", "=", $user->EMAIL)->where("PAYMENT_STATUS", "=", 1)->get();
        $totalTopup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)
            ->where("EMAIL", "=", $user->EMAIL)->where("PAYMENT_STATUS", "=", 1)->sum("CREDIT");

        $listTopup = DB::select("SELECT t.CREATED_AT AS CREATED_AT, t.CREDIT AS CREDIT, 1 AS STATUS FROM top_up t WHERE EMAIL = '".$user->EMAIL."' UNION SELECT ts.CREATED_AT AS CREATED_AT, ts.COMMISION AS CREDIT, 2 AS STATUS FROM transaction_sting ts WHERE EMAIL_FARMER = '".$user->EMAIL."' ORDER BY 1");
        return view("Buyer.report.report", compact("role", "route", "user", "listTopup", "totalTopup"));
    }

    public function Auction()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $auctionPending = LelangSting::where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", "0")->get();
        $auctionProgress = LelangSting::where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", "1")->get();
        $auctionDone = LelangSting::where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", "2")->get();
        $auctionCanceled = LelangSting::where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", "-1")->get();

        return view("Buyer.auction.auction", compact(
            "role",
            "route",
            "user",
            "auctionPending",
            "auctionProgress",
            "auctionDone",
            "auctionCanceled"
        ));
    }
    public function AuctionMake()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $categories = Category::all();
        return view("Buyer.auction.make", compact(
            "role",
            "route",
            "user",
            "categories"
        ));
    }
    public function AuctionMakeProcess(Request $request)
    {
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

        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $newkey =  UserController::GenerateRandomToken(7);
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

        $categories = explode(',', $request->input('category'));
        if (end($categories) == "") {
            array_pop($categories);
        }

        foreach ($categories as $c) {
            $sting_category = Category::where("NAMA_CATEGORY", "LIKE", "%$c%")->get()->first();
            if ($sting_category != null) {
                $newC = new LelangStingCategory();
                $newC->ID_LELANG_STING = $kode;
                $newC->ID_CATEGORY = $sting_category->ID_CATEGORY;
                $newC->save();
            }
        }
        return redirect("/buyer/auction")->with('success', 'Berhasil membuat lelang sting!');
    }
    public function CancelAuctionSting(Request $request, $id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("STATUS", 0)->get()->first();
        if ($lelang == null) {
            return redirect("/buyer/auction")->with("error", "Lelang sting tidak ditemukan");
        }
        $lelang->STATUS = -1;
        $lelang->save();
        return redirect("/buyer/auction")->with("success", "Berhasil cancel lelang sting");
    }
    public function SuscribeIndexView()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        return view("Buyer.subscription.index", compact("role", "route", "user"));
    }
    public function SuscribeConfirmView()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        return view("Buyer.subscription.confirm", compact("role", "route", "user"));
    }
    public function SuscribeConfirm(Request $request)
    {
        $harga = 500000;
        $rule = [
            "mode" => "required"
        ];
        $message = [
            "mode.required" => "Mode Pembayaran harus dipilih"
        ];

        $request->validate($rule, $message);
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $mode = $request->input("mode");
        if ($mode == "credit") {
            //cek cukup tidak
            if ($user->BALANCE < $harga) {
                return  redirect()->back()->with("error", "Harga tidak mencukupi saldo anda");
            }
            //tambah record top up
            $topupNew = new TopUp();
            $kodeTopUp = UserController::GenerateRandomToken(30);
            $snap = UserController::GenerateRandomToken(36);
            $topupNew->KODE_TOPUP = $kodeTopUp;
            $topupNew->EMAIL = $user->EMAIL;
            $topupNew->CREDIT =  $harga * -1;
            $topupNew->PAYMENT_STATUS = 1;
            $topupNew->SNAP_TOKEN = $snap;
            $topupNew->save();
            //kurangi saldo dan toggle status subscribe
            $userUpdate = User::where("EMAIL", $user->EMAIL)->get()->first();
            $userUpdate->BALANCE -= $harga;
            $userUpdate->SUBSCRIBED = 1;
            $userUpdate->SUBSCRIBED_AT = now();
            $userUpdate->save();

            Auth::login($userUpdate);
            return redirect("/buyer/subscribe");
        } else {
            return redirect("/buyer/subscribe/pay");
        }
    }

    public function CancelOrderedSting(Request $request, $id)
    {
        $transCheck = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($transCheck == null) {
            return redirect("/buyer/sting/ordered")->with("error", "Order sting not found");
        }
        $transCheck->STATUS = -2;
        $transCheck->save();
        return redirect("/buyer/sting/ordered")->with(
            "open-modal",
            "Berhasil cancel order sting"
        );
    }

    public function CompleteSting(Request $request, $id)
    {
        $user = Auth::user();
        $rating = $request->input("rating");
        $review = $request->input("review");
        $order = TransactionSting::where("ID_TRANSACTION", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 3)
            ->get()->first();
        if ($order == null) {
            return redirect("/buyer/sting/ordered")->with("error", "Order tidak ditemukan");
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

        return redirect("/buyer/sting/ordered")->with("success", "Berhasil finish order!");
    }

    public function OwnerStingView(Request $request, $id)
    {
        //ASD
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $sting = Sting::where("ID_STING", $id)->get()->first();
        if ($sting == null) {
            return redirect("/buyer/sting")->with("error", "Sting tidak ditemukan");
        }
        //akumulasi rating
        $author = $sting->author;
        $jumlahPemberiRating = sizeof(Sting::where("EMAIL_BEEWORKER", $author->EMAIL)->get());
        $totalRating = DB::select(
            'select sum(RATING) as jumlah from sting where EMAIL_BEEWORKER = ?',
            [$author->EMAIL]
        );
        $rating = $totalRating[array_key_first($totalRating)]->jumlah;
        $rating /= $jumlahPemberiRating;

        $joinDate = Carbon::parse($author->EMAIL_VERIFIED_AT)->format('F Y');
        $reviews = DB::select("
        select t.REVIEW, u.* from transaction_sting t join sting s on t.ID_STING = s.ID_STING
        join user u on u.EMAIL = t.EMAIL_FARMER
        where s.EMAIL_BEEWORKER=? and t.REVIEW<>'' limit 5", [
            $author->EMAIL
        ]);
        $categoryInvolve = [];
        $stingshave = $author->stings;
        foreach ($stingshave as $key => $sting1) {
            $sc = $sting1->sting_category;
            foreach ($sc as $key1 => $c) {
                if (!in_array($c->category->NAMA_CATEGORY, $categoryInvolve)) {
                    $categoryInvolve[] = $c->category->NAMA_CATEGORY;
                }
            }
        }
        return view("Buyer.sting.owner", compact(
            "role",
            "route",
            "user",
            "sting",
            "id",
            "rating",
            "joinDate",
            "reviews",
            "jumlahPemberiRating",
            "author",
            "categoryInvolve"
        ));
    }


    public function DetailAuctionSting(Request $request, $id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("STATUS", 1)->get()->first();
        if ($lelang == null) {
            return redirect("/buyer/auction")->with("error", "Lelang sting tidak ditemukan");
        }

        $orderDate = Carbon::parse($lelang->CREATED_AT)->format('d F Y');
        $acceptedDate = Carbon::parse($lelang->DATE_START)->format('d F Y');
        $revisionLeft = 2;



        if ($lelang->STATUS == -1) {
            $status = 'Deleted';
            $statusColor = 'text-red-600';
        } elseif ($lelang->STATUS == 0) {
            $status = 'Pending';
            $statusColor = 'text-yellow-400';
        } elseif ($lelang->STATUS == 1) {
            $status = 'In Progress';
            $statusColor = 'text-amber-800';
        } elseif ($lelang->STATUS == 2) {
            $status = 'Selesai';
            $statusColor = 'text-primary';
        } else {
            $status = 'Unknown';
        }
        $waiting = false;
        //beri pengecekkan kalo sedang disubmit dan nunggu approve
        if ($lelang->FILENAME_FINAL != "" && $lelang->STATUS == 1) {
            // $status = "Waiting Approval";
            $waiting = true;
        }

        $complains = StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)->get();
        //get type lelang sting

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "<>", "")->get();
        $revisionLeft -= sizeof($revisionDone);


        $revisionWaiting = sizeof(StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "")->get());

            $chats = ChatSting::where("ID_TRANSACTION",$id)->get();
        return view(
            "Buyer.auction.detail",
            compact(
                "role",
                "route",
                "user",
                "lelang",
                "orderDate",
                "acceptedDate",
                "revisionLeft",
                "revisionWaiting",
                "status",
                "statusColor",
                "waiting",
                "complains",
                "id",
                "chats"
            )
        );
    }

    public function CompleteAuction(Request $request, $id)
    {
        //TODO
        $user = Auth::user();
        $rating = $request->input("rating");
        $review = $request->input("review");
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 2)
            ->get()->first();
        if ($lelang == null) {
            return redirect("/buyer/auction")->with("error", "Lelang sting tidak ditemukan");
        }
        $lelang->RATE = $rating;
        $lelang->REVIEW = $review;
        $lelang->STATUS = 2;
        $lelang->save();

        $emailBeeworker = $lelang->beeworker->EMAIL;
        $userUpd = User::where("EMAIL", $emailBeeworker)->get()->first();
        $userUpd->BALANCE += $lelang->COMMISION;
        $userUpd->save();


        // $jumlahPemberiRating = sizeof(
        //     TransactionSting::where("ID_STING", $order->ID_STING)
        //     ->where("REVIEW","<>","")->get());

        // $totalRating = DB::select(
        //     'select sum(RATE) as jumlah from transaction_sting where ID_STING = ? and REVIEW <> "" ',
        //     [$order->ID_STING]
        // );

        // //ini untuk update sting rating
        // $rating = $totalRating[array_key_first($totalRating)]->jumlah;
        // $rating /= $jumlahPemberiRating;

        // $stingUpd = Sting::where("ID_STING",$order->ID_STING)->get()->first();
        // $stingUpd->RATING = $rating;
        // $stingUpd->save();

        return redirect("/buyer/auction")->with("success", "Berhasil finish lelang sting!");
    }


    public function DeclineAuctionSting(Request $request, $id)
    {

        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->where("STATUS", ">", 0)
            ->where("STATUS", "<", 2)
            ->get()->first();
        if ($lelang == null) {
            return redirect("/buyer/auction")->with("error", "Lelang sting tidak ditemukan");
        }
        $revisionLeft = 2;

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "<>", "")->get();

        $revisionLeft -= sizeof($revisionDone);

        if ($revisionLeft < 1) {
            return redirect("/buyer/auction/detail/$id")->with("error", "Batas revisi sudah mencapai maksimum");
        }

        $complain = new StingComplainResolve();
        $complain->ID_TRANSACTION = $id;
        $complain->COMPLAIN = $request->input("complain");
        $complain->TYPE = 1;
        $complain->FILE_REVISION = "";
        $complain->save();

        return redirect()->back()->with("success", "Berhasil Decline Lelang Submission dan Mengirim Complain");
    }

    public function RateReviewAuction(Request $request, $id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $lelang = LelangSting::where("ID_LELANG_STING", $id)
            ->where("EMAIL_FARMER", $user->EMAIL)
            ->get()->first();
        if ($lelang == null) {
            return redirect("/buyer/auction")->with("error", "Lelang sting tidak ditemukan");
        }

        return view(
            "Buyer.auction.review",
            compact(
                "role",
                "route",
                "user",
                "lelang",
                "id"
            )
        );
    }
    public function AddChat(Request $request, $id)
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $replying = $request->input("replying");
        $ref = $request->input("reference");
        $chat = $request->input("chat");
        if ($ref != null) {
        }
        if ($replying == -1) {
            $replying = null;
        }

        $new = new ChatSting();
        $new->ID_TRANSACTION = $id;
        $new->EMAIL = $user->EMAIL;
        $new->BODY = $chat;
        $new->TYPE = 0; //Farmer
        $new->ID_COMPLAIN = $ref;
        $new->REPLY_TO = $replying;
        $new->save();
        return redirect()->back()->with("success", "Success send chat");
    }
}
