<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChatSting;
use App\Models\Sting;
use App\Models\StingCategory;
use App\Models\LelangSting;
use App\Models\StingComplainResolve;
use App\Models\StingMedia;
use App\Models\TransactionSting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
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
    public function Dashboard()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $join = $user->CREATED_AT;
        $join = Carbon::parse($join)->format('d F Y');

        $jumlahSting = Sting::where("EMAIL_BEEWORKER", "=", $user->EMAIL)->count();
        $averageBasic = Sting::where("EMAIL_BEEWORKER", "=", $user->EMAIL)->avg("PRICE_BASIC");
        $averagePremium = Sting::where("EMAIL_BEEWORKER", "=", $user->EMAIL)->avg("PRICE_PREMIUM");

        $finished = DB::select(
            'SELECT COUNT(*) as JUMLAH FROM transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING AND s.EMAIL_BEEWORKER = ? AND t.STATUS = 3',
            [$user->EMAIL]
        )[0]->JUMLAH;

        $onGoing = DB::select(
            'SELECT COUNT(*) as JUMLAH FROM transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING AND s.EMAIL_BEEWORKER = ? AND (t.STATUS = 2 OR t.STATUS = 1)',
            [$user->EMAIL]
        )[0]->JUMLAH;


        $jumlahLelang = LelangSting::where("EMAIL_BEEWORKER", "=", $user->EMAIL)->where("STATUS", "=", 1)->where("STATUS", "=", 2)->count();

        $avgRating = Sting::where("EMAIL_BEEWORKER", "=", $user->EMAIL)->avg("RATING");
        $avgRating = (number_format((int)$avgRating, 2, '.', ''));

        $pendapatan = DB::select(
            'SELECT SUM(t.COMMISION) as PENDAPATAN FROM transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING AND s.EMAIL_BEEWORKER = ?',
            [$user->EMAIL]
        )[0]->PENDAPATAN;

        $IDSting = DB::select(
            'SELECT t.ID_STING, COUNT(*) FROM transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING AND s.EMAIL_BEEWORKER = ?
            GROUP BY t.ID_STING
            ORDER BY 2 DESC',
            [$user->EMAIL]
        );

        if ($IDSting == null || $IDSting == "" || $IDSting == []) {
            $mostBought = "No Sting Purchased";
        } else {
            $mostBought = Sting::find($IDSting[0]->ID_STING)->TITLE_STING;
        }

        return view("Seller.dashboard", compact(
            "role",
            "route",
            "user",
            "join",
            "jumlahSting",
            "averageBasic",
            "averagePremium",
            "mostBought",
            "finished",
            "onGoing",
            "jumlahLelang",
            "avgRating",
            "pendapatan"
        ));
    }
    public function ListSting()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $stings = Sting::where('EMAIL_BEEWORKER', $user->EMAIL)->get();

        return view("Seller.sting.list", compact("role", "route", "user", "stings"));
    }
    public function Order()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        // $userNya = $user->stings[0]->ID_STING;

        $arrOrder = [];
        $acceptedOrder = [];
        $declinedOrder = [];
        $doneOrder = [];
        $arrFarmer = [];

        foreach ($user->stings as $key => $stingNya) {
            foreach (TransactionSting::where('ID_STING', $stingNya->ID_STING)->where('STATUS', '0')->get() as $key => $orderNya) {
                // dump($orderNya);
                // dump(User::find($orderNya->EMAIL_FARMER)->NAMA);
                $arrOrder[] = [$orderNya, User::find($orderNya->EMAIL_FARMER)->NAMA];
            }

            foreach (TransactionSting::where('ID_STING', $stingNya->ID_STING)
                ->where('STATUS', ">", 0)
                ->where('STATUS', "<", 3)
                ->get() as $key => $orderNya) {
                $acceptedOrder[] = [$orderNya, User::find($orderNya->EMAIL_FARMER)->NAMA];
            }

            foreach (TransactionSting::where('ID_STING', $stingNya->ID_STING)->where('STATUS', '-1')->get() as $key => $orderNya) {
                $declinedOrder[] = [$orderNya, User::find($orderNya->EMAIL_FARMER)->NAMA, User::find($orderNya->EMAIL_FARMER)->PICTURE];
            }
            foreach (TransactionSting::where('ID_STING', $stingNya->ID_STING)->where('STATUS', '3')->get() as $key => $orderNya) {
                $doneOrder[] = [$orderNya, User::find($orderNya->EMAIL_FARMER)->NAMA, User::find($orderNya->EMAIL_FARMER)->PICTURE];
            }
        }
        // dump($userNya);

        // $arrOrder = TransactionSting::where('ID_STING','S_0085781')->where('STATUS','0')->get();
        // dd($orderNya);

        return view("Seller.sting.order", compact(
            "role",
            "route",
            "user",
            "arrOrder",
            "acceptedOrder",
            "declinedOrder",
            "doneOrder",
        ));
    }
    public function AcceptOrder($id)
    {
        $user = Auth::user();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($order == null) {
            return redirect("/seller/order")->with("error", "Order not found");
        }
        if ($order->STATUS != 0) {
            return redirect("/seller/order")->with("error", "Order ini tidak dalam keadaan pending");
        }
        $order->STATUS = 1;
        $order->DATE_START = now();
        $order->save();
        return redirect("/seller/order")->with("success", "Berhasil menerima order!");
    }
    public function DeclineOrder($id)
    {
        $user = Auth::user();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($order == null) {
            return redirect("/seller/order")->with("error", "Order not found");
        }
        if ($order->STATUS != 0) {
            return redirect("/seller/order")->with("error", "Order ini tidak dalam keadaan pending");
        }
        $order->STATUS = -1;
        $order->save();
        return redirect("/seller/order")->with("info", "Berhasil cancel order!");
    }
    public function Report()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $transaksi = [];
        $totalPendapatanBersih = 0;
        return view("Seller.report.report", compact("role", "route", "user", "transaksi", "totalPendapatanBersih"));
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
        } else {
            $transaksi1 = TransactionSting::with("sting")->where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->get();
            // $transaksi = DB::select("SELECT * FROM transaction_sting t, sting s WHERE s.ID_STING = s.ID_STING AND s.EMAIL_BEEWORKER = $user->EMAIL");
            $transaksi = [];
            $totalPendapatanKotor = 0;
            $totalTax = 0;
            // dd($transaksi1);
            foreach ($transaksi1 as $t) {
                if ($t->sting->EMAIL_BEEWORKER == $user->EMAIL) {
                    $transaksi[] = $t;
                    $totalPendapatanKotor += $t->COMMISION;
                    $totalTax += $t->TAX;
                }
            }
            // dd($transaksi[0]->sting->EMAIL_BEEWORKER);
            // dd($totalPendapatanKotor);
            // $totalPendapatanKotor = TransactionSting::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->where("EMAIL_FARMER", "=", $user->EMAIL)->sum("COMMISION");
            // $totalTax = TransactionSting::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->where("EMAIL_FARMER", "=", $user->EMAIL)->sum("TAX");
            $totalPendapatanBersih = $totalPendapatanKotor - $totalTax;

            return view("Seller.report.report", compact(
                "role",
                "route",
                "user",
                "transaksi",
                "totalPendapatanBersih",
                "totalPendapatanKotor",
                "totalTax"
            ));
        }
    }
    public function Auction()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);

        $route = RouteController::getRouteArray();
        //todo

        // $stingSellerSudahPunya = DB::select("",[]);
        // $arrLelang = LelangSting::where('STATUS', '0')-> get();
        //1. ambil sting yg seller itu sudah punya
        // 2. cari list category dari list sting nomor 1
        // 3. lelang sting akan ditampilkan kalo salah satu kategori yg dipunyai ada di list kategori nomor 2
        $arrLelang = DB::select("select l.*, l.STATUS as LELANGSTATUS, c.NAMA_CATEGORY,u.* from lelang_sting l
        join lelang_sting_category lc on lc.ID_LELANG_STING = l.ID_LELANG_STING
        join category c on c.ID_CATEGORY = lc.ID_CATEGORY join user u on u.EMAIL = l.EMAIL_FARMER
        where l.STATUS = 0 and c.ID_CATEGORY in (
        select distinct c.ID_CATEGORY from sting s join sting_category sc on s.ID_STING = sc.ID_STING
        join category c on c.ID_CATEGORY = sc.ID_CATEGORY where s.EMAIL_BEEWORKER=?
        )
        ", [$user->EMAIL]);

        $onProgressLelang = LelangSting::where("EMAIL_BEEWORKER", $user->EMAIL)
            ->where("STATUS", 1)
            ->get();

        return view("Seller.auction.auction", compact(
            "role",
            "route",
            "user",
            "arrLelang",
            "onProgressLelang"
        ));
    }
    public function AccAuction($id)
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);

        $route = RouteController::getRouteArray();
        $lelangan = LelangSting::where('ID_LELANG_STING', $id)->get()->first();
        $lelangan->EMAIL_BEEWORKER = $user->EMAIL;
        $lelangan->STATUS = 1;
        $lelangan->DATE_START = date("Y-m-d H:i:s");
        $lelangan->save();
        return redirect('seller/auction')->with('success', 'succesfull taking auction');;
    }
    public function UploadStingForm()
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        return view("Seller.sting.add", compact("role", "route", "user"));
    }

    public function AddStingView()
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $categories = Category::all();
        $route = RouteController::getRouteArray();
        return view("Seller.sting.add", compact("role", "route", "user", "categories"));
    }

    public function AddSting(Request $request)
    {
        $rules = [
            'title' => ["required"],
            'deskripsi' => ["required"],
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'media1' => ["required"], //belum tak anu tipe data apa aja
            'media1.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'media2' => ["required"], //belum tak anu tipe data apa aja
            'media2.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'media3' => ["required"], //belum tak anu tipe data apa aja
            'media3.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'media4' => ["required"], //belum tak anu tipe data apa aja
            'media4.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'harga1' => ["required", "numeric"],
            'revisi1' => ["required", "numeric"],
            'desk1' => ["required"],
            'harga2' => ["required", "numeric"],
            'revisi2' => ["required", "numeric"],
            'desk2' => ["required"],
            'category' => ["required"]
        ];
        $messages = [
            "required" => "field tidak boleh kosong",
            "foto.required" => "jangan lupa masukkan thumbnail",
            "harga1.required" => "harga basic tidak boleh kosong",
            "harga2.required" => "harga premium tidak boleh kosong",
            "desk1.required" => "deskripsi basic tidak boleh kosong",
            "desk2.required" => "deskripsi premium tidak boleh kosong",
            "category.required" => "Anda harus memilih kategori",
        ];
        $request->validate($rules, $messages);

        //make unique id
        $s = 'S_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;


        $user = Auth::user();

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();

        $media1 = $request->file('media1');
        $media2 = $request->file('media2');
        $media3 = $request->file('media3');
        $media4 = $request->file('media4');

        $namaFileMedia1 = '1M_' . $newkey . "." . $media1->getClientOriginalExtension();
        $namaFileMedia2 = '2M_' . $newkey . "." . $media2->getClientOriginalExtension();
        $namaFileMedia3 = '3M_' . $newkey . "." . $media3->getClientOriginalExtension();
        $namaFileMedia4 = '4M_' . $newkey . "." . $media4->getClientOriginalExtension();
        // masukkan ke db STING
        $sting = new Sting();
        $sting->ID_STING = $kode;
        $sting->DESKRIPSI = $request->input('deskripsi');
        $sting->TITLE_STING = $request->input('title');
        $sting->EMAIL_BEEWORKER = $user->EMAIL;
        $sting->NAMA_THUMBNAIL = $namaFilePhoto;
        $sting->RATING = 0.0;
        $sting->DESKRIPSI_BASIC = $request->input('desk1');
        $sting->DESKRIPSI_PREMIUM = $request->input('desk2');
        $sting->PRICE_BASIC = $request->input('harga1');
        $sting->PRICE_PREMIUM = $request->input('harga2');
        $sting->MAX_REVISION_BASIC = $request->input('revisi1');
        $sting->MAX_REVISION_PREMIUM = $request->input('revisi2');
        $sting->STATUS = 1;
        $sting->save();

        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-thumbnails', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-thumbnails", $namaFilePhoto);
        }

        // //masukkan ke db sting_category
        $categories = explode(',', $request->input('category'));
        if (end($categories) == "") {
            array_pop($categories);
        }

        foreach ($categories as $c) {
            $sting_category = Category::where("NAMA_CATEGORY", "LIKE", "%$c%")->get()->first();
            if ($sting_category != null) {
                $newC = new StingCategory();
                $newC->ID_STING = $kode;
                $newC->ID_CATEGORY = $sting_category->ID_CATEGORY;
                $newC->save();
            }
        }

        //masukkan ke db sting_media
        $media = new StingMedia();
        $media->ID_STING = $kode;
        $media->FILENAME = $namaFileMedia1;
        $media->save();
        if (env("APP_ENV") == "production") {
            $request->file("media1")->storeAs('sting-media', $namaFileMedia1, 'public_html');
        } else {
            $request->file('media1')->storeAs("public/sting-media", $namaFileMedia1);
        }

        $media = new StingMedia();
        $media->ID_STING = $kode;
        $media->FILENAME = $namaFileMedia2;
        $media->save();
        if (env("APP_ENV") == "production") {
            $request->file("media2")->storeAs('sting-media', $namaFileMedia2, 'public_html');
        } else {
            $request->file('media2')->storeAs("public/sting-media", $namaFileMedia2);
        }

        $media = new StingMedia();
        $media->ID_STING = $kode;
        $media->FILENAME = $namaFileMedia3;
        $media->save();
        if (env("APP_ENV") == "production") {
            $request->file("media3")->storeAs('sting-media', $namaFileMedia3, 'public_html');
        } else {
            $request->file('media3')->storeAs("public/sting-media", $namaFileMedia3);
        }

        $media = new StingMedia();
        $media->ID_STING = $kode;
        $media->FILENAME = $namaFileMedia4;
        $media->save();
        if (env("APP_ENV") == "production") {
            $request->file("media4")->storeAs('sting-media', $namaFileMedia4, 'public_html');
        } else {
            $request->file('media4')->storeAs("public/sting-media", $namaFileMedia4);
        }



        // $photo->move('image', $namaFilePhoto);

        // $path =

        return redirect()->back()->with('success', 'Your sting has been added successfully');
    }

    public function EditStingView($id)
    {
        $user  = Auth::user();
        $categories = Category::all();
        $sting = Sting::where('ID_STING', $id)->get()->first();
        $route = RouteController::getRouteArray();
        $stingcategory = StingCategory::where('ID_STING', $id)->get();
        return view("Seller.sting.edit", compact("categories", "sting", "stingcategory", "route", "user"));
    }

    public function EditSting(Request $request, $id)
    {
        $rules = [
            'title' => ["required"],
            'deskripsi' => ["required"],
            // 'foto' => ["required"], //belum tak anu tipe data apa aja
            // 'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],
            'harga1' => ["required", "numeric"],
            'revisi1' => ["required", "numeric"],
            'desk1' => ["required"],
            'harga2' => ["required", "numeric"],
            'revisi2' => ["required", "numeric"],
            'desk2' => ["required"],
            // 'category' => ["required"]
        ];
        $messages = [
            "required" => "field :attribute tidak boleh kosong",
            "foto.required" => "jangan lupa masukkan foto",
            "harga1.required" => "harga basic tidak boleh kosong",
            "harga2.required" => "harga premium tidak boleh kosong",
            "desk1.required" => "deskripsi basic tidak boleh kosong",
            "desk2.required" => "deskripsi premium tidak boleh kosong",
            "category.required" => "Anda harus memilih kategori",
        ];
        $request->validate($rules, $messages);

        //update sting
        $sting = Sting::where('ID_STING', $id)->get()->first();
        $sting->DESKRIPSI = $request->input('deskripsi');
        $sting->TITLE_STING = $request->input('title');
        $sting->DESKRIPSI_BASIC = $request->input('desk1');
        $sting->DESKRIPSI_PREMIUM = $request->input('desk2');
        $sting->PRICE_BASIC = $request->input('harga1');
        $sting->PRICE_PREMIUM = $request->input('harga2');
        $sting->MAX_REVISION_BASIC = $request->input('revisi1');
        $sting->MAX_REVISION_PREMIUM = $request->input('revisi2');
        $sting->STATUS = 1;
        $sting->save();
        // dd($id);
        return back()->with('success', 'edit succesfull');
    }

    public function PictureStingView($id)
    {
        $user  = Auth::user();

        $sting = Sting::where('ID_STING', $id)->get()->first();
        $route = RouteController::getRouteArray();
        $media1 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '1%')
            ->get()->first();

        $media2 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '2%')
            ->get()->first();

        $media3 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '3%')
            ->get()->first();

        $media4 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '4%')
            ->get()->first();


        return view("Seller.sting.picture", compact("sting",  "route", "user", "media1", "media2", "media3", "media4"));
    }

    public function PictureStingThumbnail($id, Request $request)
    {
        $rules = [
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],

            // 'category' => ["required"]
        ];
        $messages = [
            "foto.required" => "jangan lupa masukkan foto",
        ];
        $request->validate($rules, $messages);

        //change thumbnail
        $s = 'S_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();
        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-thumbnails', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-thumbnails", $namaFilePhoto);
        }

        $sting = Sting::where('ID_STING', $id)->get()->first();
        $sting->NAMA_THUMBNAIL = $namaFilePhoto;
        $sting->save();
        return back()->with('success', 'edit succesfull');
    }

    public function PictureMedia1Thumbnail($id, Request $request)
    {
        $rules = [
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],

            // 'category' => ["required"]
        ];
        $messages = [
            "foto.required" => "jangan lupa masukkan foto",
        ];
        $request->validate($rules, $messages);

        $s = '1M_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();

        //get id
        $media1 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '1%')
            ->get()->first();
        $idmedia = $media1->ID_STING_MEDIA;

        $media = StingMedia::where('ID_STING_MEDIA', $idmedia)->get()->first();
        $media->FILENAME = $namaFilePhoto;
        $media->save();

        //save foto
        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-media', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-media", $namaFilePhoto);
        }

        return back()->with('success', 'edit succesfull');
    }

    public function PictureMedia2Thumbnail($id, Request $request)
    {
        $rules = [
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],

            // 'category' => ["required"]
        ];
        $messages = [
            "foto.required" => "jangan lupa masukkan foto",
        ];
        $request->validate($rules, $messages);

        $s = '2M_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();

        //get id
        $media1 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '2%')
            ->get()->first();
        $idmedia = $media1->ID_STING_MEDIA;

        $media = StingMedia::where('ID_STING_MEDIA', $idmedia)->get()->first();
        $media->FILENAME = $namaFilePhoto;
        $media->save();

        //save foto
        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-media', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-media", $namaFilePhoto);
        }

        return back()->with('success', 'edit succesfull');
    }

    public function PictureMedia3Thumbnail($id, Request $request)
    {
        $rules = [
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],

            // 'category' => ["required"]
        ];
        $messages = [
            "foto.required" => "jangan lupa masukkan foto",
        ];
        $request->validate($rules, $messages);

        $s = '3M_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();

        //get id
        $media1 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '3%')
            ->get()->first();
        $idmedia = $media1->ID_STING_MEDIA;

        $media = StingMedia::where('ID_STING_MEDIA', $idmedia)->get()->first();
        $media->FILENAME = $namaFilePhoto;
        $media->save();

        //save foto
        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-media', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-media", $namaFilePhoto);
        }

        return back()->with('success', 'edit succesfull');
    }

    public function PictureMedia4Thumbnail($id, Request $request)
    {
        $rules = [
            'foto' => ["required"], //belum tak anu tipe data apa aja
            'foto.*' => ["required", "mimes:jpeg,png,jpg,svg", "max:2048"],

            // 'category' => ["required"]
        ];
        $messages = [
            "foto.required" => "jangan lupa masukkan foto",
        ];
        $request->validate($rules, $messages);

        $s = '4M_';
        $newkey =  UserController::GenerateRandomToken(7);
        $kode = $s . $newkey;

        $photo = $request->file('foto');
        $namaFilePhoto = $kode . "." . $photo->getClientOriginalExtension();

        //get id
        $media1 = StingMedia::where('ID_STING', $id)
            ->where('FILENAME', 'like', '4%')
            ->get()->first();
        $idmedia = $media1->ID_STING_MEDIA;

        $media = StingMedia::where('ID_STING_MEDIA', $idmedia)->get()->first();
        $media->FILENAME = $namaFilePhoto;
        $media->save();

        //save foto
        if (env("APP_ENV") == "production") {
            $request->file("foto")->storeAs('sting-media', $namaFilePhoto, 'public_html');
        } else {
            // $request->file("foto")->store("public/sting-thumbnails");
            $request->file('foto')->storeAs("public/sting-media", $namaFilePhoto);
        }

        return back()->with('success', 'edit succesfull');
    }
    public function DetailSting(Request $request, $id)
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($order == null) {
            return redirect("/seller/order")->with("error", "Order tidak ditemukan");
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
        //get type transaction sting biasa

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 0)
            ->where("FILE_REVISION", "<>", "")->get();
        $revisionLeft -= sizeof($revisionDone);


        //CHAT
        $chats = ChatSting::where("ID_TRANSACTION", $id)->get();
        return view(
            "Seller.sting.progress.detail",
            compact(
                "role",
                "route",
                "user",
                "order",
                "orderDate",
                "acceptedDate",
                "revisionLeft",
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
    public function UploadFirstResult(Request $request, $id)
    {
        $request->validate([
            "work" => "required"
        ], [
            "required" => "File harus ada!"
        ]);
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($order == null) {
            return redirect("/seller/order")->with("error", "Order tidak ditemukan");
        }

        $kode = UserController::GenerateRandomToken(15);
        $filework = $request->file('work');
        $namaFileWork = $kode . "." . $filework->getClientOriginalExtension();

        $order->FILENAME_FINAL = $namaFileWork;
        $order->save();

        if (env("APP_ENV") == "production") {
            $request->file("work")->storeAs('order-deliver', $namaFileWork, 'public_html');
        } else {
            $request->file('work')->storeAs("public/order-deliver", $namaFileWork);
        }

        return redirect()->back()->with("success", "Berhasil deliver order!");
    }
    public function UploadRevision(Request $request, $id)
    {
        $request->validate([
            "revision" => "required"
        ], [
            "required" => "File harus ada!"
        ]);
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $order = TransactionSting::where("ID_TRANSACTION", $id)->get()->first();
        if ($order == null) {
            return redirect("/seller/order")->with("error", "Order tidak ditemukan");
        }
        $revisi = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)->get()->first();

        if ($revisi == null) {
            return redirect("/seller/order")->with("error", "Complain tidak ditemukan");
        }

        $kode = UserController::GenerateRandomToken(16);
        $filework = $request->file('revision');
        $namaFileWork = $kode . "." . $filework->getClientOriginalExtension();

        $order->FILENAME_FINAL = $namaFileWork;
        $order->save();

        $revisi->FILE_REVISION = $namaFileWork;
        $revisi->save();

        if (env("APP_ENV") == "production") {
            $request->file("revision")->storeAs('order-deliver', $namaFileWork, 'public_html');
        } else {
            $request->file('revision')->storeAs("public/order-deliver", $namaFileWork);
        }

        return redirect()->back()->with("success", "Berhasil deliver order!");
    }
    public function TakeAuction(Request $request, $id)
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $lelang = LelangSting::where("ID_LELANG_STING", $id)->get()->first();
        if ($lelang == null) {
            return redirect("/seller/auction")->with("error", "Lelang tidak ditemukan");
        }

        $userUpd = User::where("EMAIL", $lelang->EMAIL_FARMER)->get()->first();
        $userUpd->BALANCE -= ($lelang->COMMISION + $lelang->TAX);
        $userUpd->save();

        $lelang->STATUS = 1;
        $lelang->DATE_START = now();
        $lelang->EMAIL_BEEWORKER = $user->EMAIL;
        $lelang->save();
        return redirect("/seller/auction")->with("success", "Berhasil menerima lelang!");
    }
    public function DetailAuction(Request $request, $id)
    {

        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)->get()->first();
        if ($lelang == null) {
            return redirect("/seller/auction")->with("error", "Lelang tidak ditemukan");
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
            $status = "Waiting Approval";
            $waiting = true;
        }

        $complains = StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)->get();
        //get type lelang sting

        $revisionDone =  StingComplainResolve::where("ID_TRANSACTION", $id)->where("TYPE", 1)
            ->where("FILE_REVISION", "<>", "")->get();
        $revisionLeft -= sizeof($revisionDone);

        $chats = ChatSting::where("ID_TRANSACTION", $id)->get();
        return view(
            "Seller.auction.detail",
            compact(
                "role",
                "route",
                "user",
                "lelang",
                "orderDate",
                "acceptedDate",
                "revisionLeft",
                "status",
                "statusColor",
                "waiting",
                "complains",
                "id",
                "chats"
            )
        );
    }

    public function UploadFirstResultAuction(Request $request, $id)
    {
        $request->validate([
            "work" => "required"
        ], [
            "required" => "File harus ada!"
        ]);
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)->get()->first();
        if ($lelang == null) {
            return redirect("/seller/auction")->with("error", "Lelang tidak ditemukan");
        }

        $kode = UserController::GenerateRandomToken(18);
        $filework = $request->file('work');
        $namaFileWork = $kode . "." . $filework->getClientOriginalExtension();

        $lelang->FILENAME_FINAL = $namaFileWork;
        $lelang->save();

        if (env("APP_ENV") == "production") {
            $request->file("work")->storeAs('order-deliver', $namaFileWork, 'public_html');
        } else {
            $request->file('work')->storeAs("public/order-deliver", $namaFileWork);
        }

        return redirect()->back()->with("success", "Berhasil deliver order!");
    }
    public function RevisionAuction(Request $request, $id)
    {
        $request->validate([
            "revision" => "required"
        ], [
            "required" => "File harus ada!"
        ]);
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)->get()->first();
        if ($lelang == null) {
            return redirect("/seller/auction")->with("error", "Lelang tidak ditemukan");
        }
        $revisi = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)->get()->first();

        if ($revisi == null) {
            return redirect("/seller/auction")->with("error", "Complain tidak ditemukan");
        }

        $kode = UserController::GenerateRandomToken(19);
        $filework = $request->file('revision');
        $namaFileWork = $kode . "." . $filework->getClientOriginalExtension();

        $lelang->FILENAME_FINAL = $namaFileWork;
        $lelang->save();

        $revisi->FILE_REVISION = $namaFileWork;
        $revisi->save();

        if (env("APP_ENV") == "production") {
            $request->file("revision")->storeAs('order-deliver', $namaFileWork, 'public_html');
        } else {
            $request->file('revision')->storeAs("public/order-deliver", $namaFileWork);
        }

        return redirect()->back()->with("success", "Berhasil deliver order!");
    }

    public function UploadRevisionAuction(Request $request, $id)
    {
        $request->validate([
            "revision" => "required"
        ], [
            "required" => "File harus ada!"
        ]);
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $lelang = LelangSting::where("ID_LELANG_STING", $id)->get()->first();
        if ($lelang == null) {
            return redirect("/seller/auction")->with("error", "Order tidak ditemukan");
        }
        $revisi = StingComplainResolve::orderBy("CREATED_AT", "DESC")
            ->where("ID_TRANSACTION", $id)->get()->first();

        if ($revisi == null) {
            return redirect("/seller/auction")->with("error", "Complain tidak ditemukan");
        }

        $kode = UserController::GenerateRandomToken(16);
        $filework = $request->file('revision');
        $namaFileWork = $kode . "." . $filework->getClientOriginalExtension();

        $lelang->FILENAME_FINAL = $namaFileWork;
        $lelang->save();

        $revisi->FILE_REVISION = $namaFileWork;
        $revisi->save();

        if (env("APP_ENV") == "production") {
            $request->file("revision")->storeAs('order-deliver', $namaFileWork, 'public_html');
        } else {
            $request->file('revision')->storeAs("public/order-deliver", $namaFileWork);
        }

        return redirect()->back()->with("success", "Berhasil deliver order!");
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
        $new->TYPE = 1; //Beeworker
        $new->ID_COMPLAIN = $ref;
        $new->REPLY_TO = $replying;
        $new->save();
        return redirect()->back()->with("success", "Success send chat");
    }


    public function softDeleteSting($id)
    {
        // TIMOTHY
        $sting = Sting::where('ID_STING', $id)->get()->first();
        $sting->delete();

        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $stings = Sting::where('EMAIL_BEEWORKER', $user->EMAIL)->get();

        return redirect("/seller/sting")->with("success","Sukses take down sting");
    }
}
