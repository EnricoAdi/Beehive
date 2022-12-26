<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LelangSting;
use App\Models\Logging;
use App\Models\Sting;
use App\Models\StingCategory;
use App\Models\TopUp;
use App\Models\TransactionSting;
use App\Models\User;
use App\Rules\RegisterUsernameRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function Dashboard()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();

        $userRegistered = DB::select("SELECT COUNT(*) as JUMLAH FROM user WHERE STATUS = 1 OR STATUS = 2")[0]->JUMLAH;
        $month = $month = date('m');
        $year = $year = date('Y');
        $userJoinedRecent = DB::select("SELECT COUNT(*) as JUMLAH FROM user WHERE SUBSTR(CREATED_AT, 6, 2) = ? and SUBSTR(CREATED_AT, 1, 4) = ?",[$month,$year])[0]->JUMLAH;
        $succeedTrans = TransactionSting::where("STATUS", "=", 3)->count();
        $avgBasicPrice = Sting::avg("PRICE_BASIC");
        $avgPremiumPrice = Sting::avg("PRICE_PREMIUM");

        $tax = TransactionSting::sum("TAX");
        $topup = abs(TopUp::where("PAYMENT_STATUS", "=", 1)->sum("CREDIT"));
        $pemasukan = $topup + $tax;

        $IDSting = DB::select('SELECT t.ID_STING, COUNT(*) FROM transaction_sting t, sting s
            WHERE s.ID_STING = t.ID_STING
            GROUP BY t.ID_STING
            ORDER BY 2 DESC');

        if ($IDSting == null || $IDSting == "" || $IDSting == []) {
            $mostBought = "No Sting Purchased";
        } else {
            $mostBought = Sting::where("ID_STING", $IDSting[0]->ID_STING)
                ->get()->first()->TITLE_STING;
        }
        //ambil kategori terpopuler dari transaction sting yang sudah berhasil
        $kategoriTerpopuler = DB::select("select c.NAMA_CATEGORY
         from
        transaction_sting t join sting s on t.ID_STING = s.ID_STING join sting_category sc  on sc.ID_STING=s.ID_STING join category c on c.ID_CATEGORY = sc.ID_CATEGORY
        where t.RATE>0
        group by c.NAMA_CATEGORY order by count(c.NAMA_CATEGORY) desc limit 1");
        if ($kategoriTerpopuler != null) {
            $kategoriTerpopuler = $kategoriTerpopuler[0]->NAMA_CATEGORY;
        }else{
            $kategoriTerpopuler = "Tidak ada kategori terpopuler";
        }
        return view("Admin.dashboard", compact(
            "route",
            "user",
            "userRegistered",
            "userJoinedRecent",
            "succeedTrans",
            "avgBasicPrice",
            "avgPremiumPrice",
            "mostBought",
            "pemasukan",
            "kategoriTerpopuler"
        ));
    }
    public function MasterUserView(Request $request)
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $users = User::orderBy("CREATED_AT", "DESC")->get();
        $filter = $request->filter ?? "Farmer";
        return view("Admin.master.user", compact("route", "user", "users", "filter"));
    }
    public function MasterUser(Request $request)
    {

        $rules = [
            "email" => [new RegisterUsernameRule()],
            "password" => "string",
            "nama" => "string",
        ];
        $customMessageRegister = [];
        $request->validate($rules, $customMessageRegister);
        if ($request->input("password") != $request->input("confirm")) {
            return redirect()->back()->with("error", "Password dan Konfirmasi harus sama");
        }

        $password = bcrypt($request->input("password"));

        $newkey =  UserController::GenerateRandomToken(40);
        $insert = User::create([
            "EMAIL" => $request->input("email"),
            "PASSWORD" => $password,
            "NAMA" => $request->input("nama"),
            "REMEMBER_TOKEN" => $newkey,
            "STATUS" => 3, //admin
            "TANGGAL_LAHIR" => now(),
            "BALANCE" => 0,
            "BIO" => "",
            "RATING" => 0,
            "PICTURE" => "DEFAULT.JPG",
            "SUBSCRIBED" => 0
        ]);

        $user = Auth::user();
        $route = RouteController::getRouteArray();

        return redirect()->back()->with("open-modal", "Success Adding Admin!");
    }

    public function DetailCategoryView($id)
    {
        $user  = Auth::user();
        $c = Category::where("ID_CATEGORY", $id)->get()->first();
        if ($c == null) {
            return redirect("/admin/master/category")
                ->with("error", "Error! Category not found");
        }
        $route = RouteController::getRouteArray();
        //return view
        return view(
            "Admin.master.categorydetail",
            compact("c", "route", "user")
        );
    }
    public function DetailCategory(Request $request, $id)
    {

        $request->validate([
            "nama" => "required"
        ]);
        $c = Category::where("ID_CATEGORY", $id)->get()->first();
        if ($c == null) {
            return redirect("/admin/master/category")
                ->with("error", "Category Tidak Ditemukan");
        }
        $c->NAMA_CATEGORY = $request->input("nama");
        $c->save();
        return redirect("/admin/master/category")
            ->with("success", "Berhasil Edit Category");
    }
    public function DeleteCategory($id)
    {
        $cat = Category::where("ID_CATEGORY", $id)->get()->first();
        if ($cat == null) {
            return redirect("/admin/master/category")
                ->with("error", "Category tidak ditemukan");
        }
        if (sizeof($cat->stingsRelated) > 0) {
            return redirect("/admin/master/category")
                ->with("error", "Ada sting terkait category ini");
        }
        $cat->delete();
        return redirect("/admin/master/category")
            ->with("success", "Berhasil Delete Category");
    }
    public function DeleteEmail($email, $from)
    {
        $userdeleted = User::where("EMAIL", $email)->get()->first();
        if ($userdeleted == null) {
            return redirect("/admin/master/user?filter=$from")
                ->with("error", "Error! User not found");
        }
        $userdeleted->delete();
        return redirect("/admin/master/user?filter=$from")
            ->with("success", "Berhasil Delete User");
    }
    public function DeleteSting($id, $catt)
    {
        $userdeleted = sting::where("ID_STING", $id)->get()->first();
        if ($userdeleted == null) {
            return redirect("/admin/master/sting?catt=$catt")
                ->with("error", "Error! Sting not found");
        }
        $userdeleted->delete();
        return redirect("/admin/master/sting?catt=$catt")
            ->with("success", "Berhasil Delete Sting");
    }
    public function DetailUserView($email, $from)
    {
        $user  = Auth::user();
        $userDetail = User::where("EMAIL", $email)->get()->first();
        if ($userDetail == null) {
            return redirect("/admin/master/user?filter=$from")
                ->with("error", "Error! User not found");
        }
        $route = RouteController::getRouteArray();
        //return view
        return view(
            "Admin.master.userdetail",
            compact("userDetail", "route", "from", "user")
        );
    }
    public function DetailUser(Request $request, $email, $from)
    {
        $user  = Auth::user();
        $userDetail = User::where("EMAIL", $email)->get()->first();
        if ($userDetail == null) {
            return redirect("/admin/master/user?filter=$from")
                ->with("error", "Error! User not found");
        }
        $route = RouteController::getRouteArray();

        $rules = [
            "name" => "required",
            "bio" => "required"
        ];
        $customMessageRegister = [
            "name.required" => "Nama harus diisi",
            "bio.required" => "Bio harus diisi"
        ];
        $request->validate($rules, $customMessageRegister);
        $user = User::where("EMAIL", $request->input("email1"))->get()->first();
        if ($user == null) {
            return redirect("/admin/master/user?filter=$from")
                ->with("error", "Something went wrong, user not founded");
        }
        $user->NAMA = $request->input("name");
        $user->BIO = $request->input("bio");
        $update = $user->save();
        if ($update) {
            return redirect("/admin/master/user?filter=$from")
                ->with("success", "Berhasil mengubah detail user");
        }
        return redirect("/admin/master/user?filter=$from")
            ->with("error", "Something went wrong");
    }
    public function MasterCategoryView()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $categories = Category::paginate(5);
        return view("Admin.master.category", compact("route", "user", "categories"));
    }
    public function MasterCategory(Request $request)
    {
        $nama = $request->input("nama");
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $categoryCheck = Category::where("NAMA_CATEGORY", "LIKE", "%" . $nama . "%")
            ->get()->first();
        if ($categoryCheck != null) {
            return redirect()->back()->with("error", "Sudah ada category serupa");
        }
        $categoryNew = new Category();
        $categoryNew->NAMA_CATEGORY = $nama;
        $categoryNew->save();

        return redirect()->back()->with("open-modal", "Success adding Category $nama!");
    }
    public function MasterStingView(Request $request)
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();

        $stings = Sting::orderBy("CREATED_AT", "DESC")->get();
        // $temp = Sting::orderBy("CREATED_AT", "DESC")->get();
        $catt = $request->catt ?? "all";

        $arrCat = StingCategory::all();
        // dd($arrCat->where('ID_CATEGORY',3));

        // $stings=[];
        // foreach ($temp as $key => $s) {
        //     $stings[] = [$s,[$s->sting_category()->get('ID_CATEGORY') ?? 0]];
        //     // dump($s->sting_category()->get('ID_CATEGORY')->first()->ID_CATEGORY ?? 0);
        // }
        // dd($stings);
        return view("Admin.master.sting", compact("route", "user", "catt", "stings", "arrCat"));
    }
    public function DetailStingView($id)
    {
        $user  = Auth::user();
        $categories = Category::all();
        $sting = Sting::where('ID_STING', $id)->get()->first();
        $route = RouteController::getRouteArray();
        $stingcategory = StingCategory::where('ID_STING', $id)->get();
        return view("Admin.master.stingEdit", compact("categories", "sting", "stingcategory", "route", "user"));
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

    public function ReportEarningsView()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $pendapatan = [];
        $topup = [];
        $totalPendapatan = 0;
        return view("Admin.report.earnings", compact("route", "user", "pendapatan", "topup", "totalPendapatan"));
    }

    public function GetReportData(Request $req)
    {
        $user = Auth::user();
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
            $pendapatan = TransactionSting::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->get();
            $topup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->get();

            $totalKomisi = TransactionSting::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->sum("TAX");
            $totalTopup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->sum("CREDIT");
            $totalPendapatan = $totalKomisi + $totalTopup;

            // $asd = DB::select("SELECT TAX FROM transaction_sting WHERE ")

            // $data = json_encode($pendapatan);
            // dd(JSON.parse($data));

            return view("Admin.report.earnings", compact(
                "route",
                "user",
                "pendapatan",
                "topup",
                "totalPendapatan"
            ));
        }
    }

    public function ReportTopupView()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $topup = [];
        $totalTopup = 0;
        return view("Admin.report.topup", compact("route", "user",  "totalTopup", "topup"));
    }

    public function GetTopupReportData(Request $req)
    {
        $user = Auth::user();
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
            $topup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->get();
            $totalTopup = TopUp::where("CREATED_AT", ">=", $tgl1)->where("CREATED_AT", "<=", $tgl2)->sum("CREDIT");
            // dump($topup);
            // dd($totalTopup);
            return view("Admin.report.topup", compact(
                "route",
                "user",
                "topup",
                "totalTopup"
            ));
        }
    }

    public function ReportStingView()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $listCategory = Category::all();
        $top = DB::select("SELECT s.TITLE_STING, u.NAMA, COUNT(t.ID_STING) as JUMLAH
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");

            $jumlah = DB::select("SELECT COUNT(t.ID_STING) as JUMLAH
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");

            $nama = DB::select("SELECT s.TITLE_STING
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");
        return view("Admin.report.sting", compact("route", "user", "listCategory", "top", "jumlah", "nama"));
    }

    public function GetReportStingData(Request $req)
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $listCategory = Category::all();

        $category = $req->category;
        if ($category == "all") {
            // dd("a");
            $top = DB::select("SELECT s.TITLE_STING, u.NAMA, COUNT(t.ID_STING) as JUMLAH
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");

            $jumlah = DB::select("SELECT COUNT(t.ID_STING) as JUMLAH
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");

            $nama = DB::select("SELECT s.TITLE_STING
            FROM transaction_sting t, sting s, user u WHERE s.EMAIL_BEEWORKER = u.EMAIL AND t.ID_STING = s.ID_STING
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING ORDER BY COUNT(t.ID_STING) DESC LIMIT 10");
        } else {
            $top = DB::select(
                "SELECT COUNT(t.ID_STING) as JUMLAH, u.NAMA, s.TITLE_STING
                FROM transaction_sting t, sting s, sting_category sc, category c, user u
                WHERE s.ID_STING = sc.ID_STING
                AND c.ID_CATEGORY = sc.ID_CATEGORY
                AND t.ID_STING = s.ID_STING
                AND s.EMAIL_BEEWORKER = u.EMAIL
                AND c.ID_CATEGORY = ?
                GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING
                ORDER BY COUNT(t.ID_STING) DESC LIMIT 10",
                [$category]
            );

            $jumlah = DB::select(
                "SELECT COUNT(t.ID_STING) as JUMLAH
            FROM transaction_sting t, sting s, sting_category sc, category c, user u
            WHERE s.ID_STING = sc.ID_STING
            AND c.ID_CATEGORY = sc.ID_CATEGORY
            AND t.ID_STING = s.ID_STING
            AND s.EMAIL_BEEWORKER = u.EMAIL
            AND c.ID_CATEGORY = ?
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING
            ORDER BY COUNT(t.ID_STING) DESC LIMIT 10",
                [$category]
            );

            $nama = DB::select(
                "SELECT s.TITLE_STING
            FROM transaction_sting t, sting s, sting_category sc, category c, user u
            WHERE s.ID_STING = sc.ID_STING
            AND c.ID_CATEGORY = sc.ID_CATEGORY
            AND t.ID_STING = s.ID_STING
            AND s.EMAIL_BEEWORKER = u.EMAIL
            AND c.ID_CATEGORY = ?
            GROUP BY t.ID_STING, u.NAMA, s.TITLE_STING
            ORDER BY COUNT(t.ID_STING) DESC LIMIT 10",
                [$category]
            );
        }
        return view("Admin.report.sting", compact(
            "route",
            "user",
            "listCategory",
            "top",
            "jumlah",
            "nama"
        ));
    }

    public function LogsView()
    {
        $user = Auth::user();
        $route = RouteController::getRouteArray();
        $logs = Logging::orderBy("ID", "desc")->paginate(10);
        return view("Admin.logs", compact("route", "user", "logs"));
    }
}
