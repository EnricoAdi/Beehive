<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\TopUp;
use App\Models\User;
use Hidehalo\Nanoid\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserControllerAPI extends Controller
{
    protected static $sessionlogin_key = "USER_LOGEDIN";
    public static function GenerateRandomToken($length = 20)
    {
        $client = new Client();
        $key = $client->generateId($size = $length, $mode = Client::MODE_DYNAMIC);

        return $key;
    }
    public function dummyView()
    {
        $z = self::GenerateRandomToken(40);
        return view("welcome", [
            "data" => json_decode($z)
        ]);
    }
    static function CekEmailForRegister(Request $request)
    {
        $dFound = User::where("EMAIL", $request->email)->get()->first();
        if ($dFound != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Email ini sudah digunakan',
                'data'      => "{}"
            ], 404);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Email ini aman untuk digunakan',
                'data'      => "{}"
            ], 200);
        }
    }
    static function Register(RegisterRequest $request)
    {
        $dRegist = $request->input();
        $dFound = User::where("EMAIL", $dRegist["email"])->get()->first();
        if ($dFound != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Email sudah digunakan',
                'data'      => []
            ], 404);
        }
        if (strlen($dRegist["password"]) < 8) {
            return response()->json([
                'success'   => false,
                'message'   => 'Panjang password minimal 8 karakter!',
                'data'      => []
            ], 403);
        }
        // encrypt dulu passwordnya
        $dRegist['password'] = bcrypt($request->input("password"));

        // $dFound = User::get()->where("EMAIL", $dRegist["email"]);
        $newkey =  UserControllerAPI::GenerateRandomToken(40);
        $insert = User::create([
            "EMAIL" => $dRegist["email"],
            "PASSWORD" => $dRegist["password"],
            "NAMA" => $dRegist["name"],
            "REMEMBER_TOKEN" => $newkey,
            // "STATUS" => $dRegist["role"],
            "STATUS" => 1, //anggap semua dari mobile jadi farmer
            "TANGGAL_LAHIR" => $dRegist["birthday"],
            "BALANCE" => 0,
            "BIO" => "",
            "RATING" => 0,
            "PICTURE" => "default.jpg",
            "SUBSCRIBED" => 0
        ]);
        if (!$insert) {
            return response()->json([
                'success'   => true,
                'message'   => 'Internal server error',
                'data'      => []
            ], 500);
        }
        //autologin
        $email = $request->input("email");

        $foundUser = User::where("EMAIL", $email)->get();

        $foundUser = $foundUser->first();

        $foundUser->ROLES = $foundUser->getRole();
        $foundUser->PASSWORD = "";
        return response()->json([
            'success'   => true,
            'message'   => 'Register Berhasil',
            'data'      => $foundUser
        ], 200);  //true
    }
    public function Login(LoginRequest $request)
    {
        //LANGKAH BUAT API -> Buat dulu class requestnya, validation di sana, baru arah ke sini
        // ENRICO
        // $request->validate($rules, $customMessageRegister);
        $email = $request->input("email");

        $foundUser = User::get()->where("EMAIL", $email)->first();
        if ($foundUser == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Email tidak terdaftar',
                'data'      => "{}"
            ], 404);
        }
        if (!Hash::check($request->input("password"), $foundUser->PASSWORD)) {

            return response()->json([
                'success'   => false,
                'message'   => 'Password tidak sesuai',
                'data'      => ""
            ], 402);
        }

        if ($foundUser->STATUS == 0) {
            return response()->json([
                'success'   => false,
                'message'   => 'Anda belum verifikasi email',
                'data'      => ""
            ], 401);
        }
        if ($foundUser->STATUS == 2) {
            return response()->json([
                'success'   => false,
                'message'   => 'Fitur untuk Beeworker di mobile belum tersedia',
                'data'      => ""
            ], 405);
        }
        $foundUser->ROLES = $foundUser->getRole();
        $foundUser->PASSWORD = "";
        return response()->json([
            'success'   => true,
            'message'   => 'Login Berhasil',
            'data'      => $foundUser
        ], 200);  //true
    }

    public function GetProfile(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        if ($user == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Session ended, need to login',
                'data'      =>  null
            ], 404);
        }
        //untuk reformat date
        $user->TANGGAL_LAHIR = date_format(date_create($user->TANGGAL_LAHIR), 'd M Y');

        return response()->json([
            'success'   => true,
            'message'   => 'Request success',
            'data'      =>  $user
        ], 201);
    }

    public function GetImage(Request $request)
    {
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();


        if (env("APP_ENV") == "production") {
            return asset("profile-pictures/$user->PICTURE");
        } else {
            return response()->download(
                storage_path('/app/public/profile-pictures/' . $user->PICTURE),
                "hasil.jpg"
            );
        }
    }


    public function ChangePassword(Request $request)
    {
        //request input diperlukan new,confirm
        if (
            $request->input("new") == null || $request->input("confirm") == null ||
            $request->input("new") == "" || $request->input("confirm") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request, new password and confirmation not found',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();

        $new = $request->input("new");
        $confirm = $request->input("confirm");
        if (strlen($new) < 8) {
            return response()->json([
                'success'   => false,
                'message'   => 'Panjang password minimal 8 karakter!',
                'data'      => "{}"
            ], 403);
        }
        if ($new != $confirm) {
            return response()->json([
                'success'   => false,
                'message'   => 'Password dan konfirmasi harus sesuai!',
                'data'      => "{}"
            ], 402);
        }
        // $userEdit = User::where("EMAIL",$user->EMAIL)->get()->first();
        $newPass = bcrypt($new);
        $success = DB::update("update user set PASSWORD=? where EMAIL=?", [
            $newPass, $user->EMAIL
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Sukses mengganti password!',
            'data'      => "{}"
        ], 201);
    }


    public function ProfileUpdate(Request $request)
    {
        //request input diperlukan name, bio
        if (
            $request->input("name") == null || $request->input("bio") == null
            || $request->input("name") == "" || $request->input("bio") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request, name and bio not found',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $email = $user->EMAIL;

        $user = User::find($email);

        $user->NAMA = $request->input("name");
        $user->BIO = $request->input("bio");
        $update = $user->save();

        if ($update) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil meng-update profile!',
                'data'      => "{}"
            ], 201);
        }
        return response()->json([
            'success'   => false,
            'message'   => 'Somethiing went wrong',
            'data'      => "{}"
        ], 500);
    }

    public function PictureUpdate(Request $request)
    {
        //request file needed picture
        if (
            $request->file("picture") == null
        ) {
            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request, picture not found',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $fileName = $request->file("picture")->hashName();
        //ini untuk upload
        if (env("APP_ENV") == "production") {
            $request->file("picture")->storeAs(
                'profile-pictures',
                $fileName,
                'public_html'
            );
            //ini kalo buat production, taruh di public_html supaya bisa diakses
        } else {
            $request->file("picture")->store("public/profile-pictures");
        }

        $email = $user->EMAIL;
        $user = User::find($email);
        $user->PICTURE = $fileName;
        $update = $user->save();
        if ($update) {
            return response()->json([
                'success'   => true,
                'message'   => "$fileName",
                'data'      => "{}"
            ], 201);
        }
        return response()->json([
            'success'   => false,
            'message'   => 'Somethiing went wrong',
            'data'      => "{}"
        ], 500);
    }

    public function topup(Request $request)
    {

        //request input diperlukan nominal
        if (
            $request->input("nominal") == null
            || $request->input("nominal") == ""
        ) {

            return response()->json([
                'success'   => false,
                'message'   => 'Bad Request, nominal not found',
                'data'      =>  "{}"
            ], 400);
        }
        $user = User::where("REMEMBER_TOKEN", $request->REMEMBER_TOKEN)->get()->first();
        $newkey = UserControllerAPI::GenerateRandomToken(22);
        $newTopup = new TopUp();
        $newTopup->KODE_TOPUP = $newkey;
        $newTopup->EMAIL = $user->EMAIL;
        $newTopup->CREDIT = $request->input("nominal");
        $newTopup->PAYMENT_STATUS = 1;
        $newTopup->SNAP_TOKEN = $newkey;
        $newTopup->save();

        $userUpdate = User::find($user->EMAIL);
        $userUpdate->BALANCE += $request->input("nominal");
        $userUpdate->save();
        return response()->json([
            'success'   => true,
            'message'   => "Berhasil top up",
            'data'      => "{ }"
        ], 201);
    }
    public function nanoIdAPI()
    {
        //function ini untuk return response berupa sebuah nanoid
        $newkey = UserControllerAPI::GenerateRandomToken(20);
        return response()->json([
            'success'   => true,
            'message'   => $newkey,
            'data'      => "{ }"
        ], 201);
    }
}
