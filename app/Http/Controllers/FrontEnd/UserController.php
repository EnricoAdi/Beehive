<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\User;
use App\Models\UserValidation;
use App\Rules\LoginPasswordRule;
use App\Rules\LoginUsernameRule;
use App\Rules\RegisterUsernameRule;
use Exception;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PDO;
use stdClass;

class UserController extends Controller
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
    public static function GenerateRandomToken($length = 20)
    {
        //ini pakai nanoid
        // ENRICO
        $client = new Client();
        $key = $client->generateId($size = $length, $mode = Client::MODE_DYNAMIC);

        return $key;
    }

    public function Login(Request $request)
    {
        // ENRICO
        $rules = [
            "email" => ["email", "filled", new LoginUsernameRule()],
            "password" => ["filled", new LoginPasswordRule($request->input("email"))]
        ];
        $customMessageRegister = [
            "filled" => ":Attribute harus diisi"
        ];
        $request->validate($rules, $customMessageRegister);
        $email = $request->input("email");

        $foundUser = User::where("EMAIL", $email)->get();

        $foundUser = $foundUser->first();

        if ($foundUser->STATUS < 1) {
            $statusString = "Not Verified";
            return redirect()->back()->with("error", "Anda belum verifikasi email");
        }

        //cek role
        Auth::login($foundUser);
        if ($foundUser->STATUS == 1) {
            return redirect("buyer")->with("success", "Login Berhasil, Welcome Farmer!");
        } else if ($foundUser->STATUS == 2) {
            return redirect("seller")->with("success", "Login Berhasil, Welcome Beeworker!");
        }else if ($foundUser->STATUS == 3) {
            return redirect("admin")->with("success", "Login Berhasil, Welcome Admin!");
        }
        return redirect("/")->with("error", "Something went wrong");
    }
    public function LogOut()
    {
        // ENRICO
        User::Unstore();
        return redirect("/")->with("success", "Logout done");
    }
    public function Register(Request $request)
    {
        //ENRICO
        /**Ini buat validation request input, email berupa string,
         * password minimal 8, nama string, role antara 0 atau 1, dan usia diatas 18
         */
        $rules = [
            "email" => ["email",new RegisterUsernameRule()],
            "password" => "string|min:8",
            "name" => "string",
            "role" => "numeric",
            "birthday" => "date|before:18 years ago",
        ];
        $customMessageRegister = [
            "min" => ":Attribute minimal 8 karakter",
            "before" => "Anda harus minimal berusia 18 tahun",
        ];
        $request->validate($rules, $customMessageRegister);
        if ($request->input("password") != $request->input("confirm")) {
            return redirect()->back()->with("error", "Password dan Konfirmasi harus sama");
        }
        $dRegist = $request->input();
        // encrypt dulu passwordnya
        $dRegist['password'] = bcrypt($request->input("password"));

        // $dFound = User::get()->where("EMAIL", $dRegist["email"]);
        $newkey =  UserController::GenerateRandomToken(40);
        $newkey1 =  UserController::GenerateRandomToken(20);
        $insert = User::create([
            "EMAIL" => $dRegist["email"],
            "PASSWORD" => $dRegist["password"],
            "NAMA" => $dRegist["name"],
            "REMEMBER_TOKEN" => $newkey,
            "STATUS" => $dRegist["role"] - 2, //di min 2 menandakan belum verifikasi email
            "TANGGAL_LAHIR" => $dRegist["birthday"],
            "BALANCE" => 0,
            "BIO" => "",
            "RATING" => 0,
            "PICTURE" => "default.jpg",
            "SUBSCRIBED" => 0
        ]);

        $uvalidate = new UserValidation();
        $uvalidate->EMAIL = $dRegist["email"];
        $uvalidate->EXP_DATE = date_add(now(), date_interval_create_from_date_string("30 days"));
        $uvalidate->STATUS = 1; //verification
        $uvalidate->TOKEN = $newkey1;
        $uvalidate->save();

        //send email
        try {
            MailController::verificationMail($dRegist["email"], $dRegist["name"], $newkey1);
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Mail failed to send");
        }

        return redirect("/register/send-email")->with("success", "Berhasil Send Email Verification! Check Your Email");
    }


    public function Profile()
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        if ($route[0] == "seller") {
            return view("Seller.profile.profile", compact("role", "route", "user"));
        } else {

            return view("Buyer.profile.profile", compact("role", "route", "user"));
        }
    }

    public function PictureView()
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        if ($route[0] == "seller") {
            return view("Seller.profile.picture", compact("role", "route", "user"));
        } else {

            return view("Buyer.profile.picture", compact("role", "route", "user"));
        }
    }
    public function ChangePasswordView()
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        if ($route[0] == "seller") {
            return view("Seller.profile.changepassword", compact("role", "route", "user"));
        } else {

            return view("Buyer.profile.changepassword", compact("role", "route", "user"));
        }
    }
    public function ChangePassword(Request $request)
    {

        $rules = [
            "old"=>"required",
            "new"=>"required|min:8",
            "confirm"=>"required",
        ];
        $message = [
            "required" =>":Attribute harus diisi!",
            "min" => "Password baru Minimal 8 huruf!"
        ];
        $request->validate($rules,$message);
        $user  = Auth::user();
        $old = $request->input("old");
        $new = $request->input("new");
        $confirm = $request->input("confirm");
        if(!Hash::check($old, $user->PASSWORD)){
            return redirect()->back()->with("error","Password tidak sesuai!");
        }
        if($new!=$confirm){
            return redirect()->back()->with("error","Password dan konfirmasi harus sesuai!");
        }
        // $userEdit = User::where("EMAIL",$user->EMAIL)->get()->first();
        $newPass = bcrypt($new);
        $success = DB::update("update user set PASSWORD=? where EMAIL=?",[
            $newPass, $user->EMAIL
        ]);
        return redirect()->back()->with("success","Berhasil mengganti password");
    }
    public function PictureUpdate(Request $request)
    {
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();
        $rules = [
            "picture" => "required",
        ];
        $customMessageRegister = [
            "required" => ":Attribute harus diisi",
        ];
        $request->validate($rules, $customMessageRegister);
        $fileName = $request->file("picture")->hashName();
        //ini untuk upload
        if(env("APP_ENV")=="production"){
            $request->file("picture")->storeAs('profile-pictures', $fileName, 'public_html'); //ini kalo buat production, taruh di public_html supaya bisa diakses
        }
        else{
            $request->file("picture")->store("public/profile-pictures");
        }


        $email = Auth::user()->EMAIL;
        $user = User::find($email);
        $user->PICTURE = $fileName;
        $update = $user->save();
        if ($update) {
            return redirect()->back()->with("success", "Berhasil meng-update profile picture!");
        }
        return redirect()->back()->with("error", "Something went wrong hmm");
    }
    public function ProfileUpdate(Request $request)
    {
        //ENRICO
        $user  = Auth::user();
        $role = $this->getRole($user->STATUS);
        $route = RouteController::getRouteArray();

        $rules = [
            "name" => "required",
            "birthday" => "required|date|before:18 years ago",
            "bio" => "required"
        ];
        $customMessageRegister = [
            "name.required" => "Nama harus diisi",
            "birthday.before" => "Anda harus minimal berusia 18 tahun",
            "bio.required" =>"Bio harus diisi"
        ];
        $request->validate($rules, $customMessageRegister);
        $email = Auth::user()->EMAIL;
        $user = User::find($email);
        $user->NAMA = $request->input("name");
        $user->TANGGAL_LAHIR = $request->input("birthday");
        $user->BIO = $request->input("bio");
        $update = $user->save();
        if ($update) {
            return redirect()->back()->with("success", "Berhasil meng-update profile!");
        }
        return redirect()->back()->with("error", "Something went wrong hmm");
    }

    /**
     * EMAIL SEND for Verification User
     */
    public function EmailSendedView()
    {
        if (!Session::has("success")) {
            return redirect("/register")->with("error", "Anda tidak mengirim email");
        }
        $route = RouteController::getRouteArray();

        return view("userAuth.emailsended", compact("route",));
    }

    public function VerifyEmail($code)
    {
        //ini untuk verify email
        //cek code valid / gak
        $uv = UserValidation::where("TOKEN", $code)->get()->first();
        if ($uv == null) {
            return redirect("/register")->with("error", "Token not found");
        }
        if ($uv->STATUS != 1) {
            return redirect("/register")->with("error", "You have been validated! Looking for something else?");
        }

        $email = $uv->EMAIL;
        $user = User::where("EMAIL", $email)->get()->first();
        if ($user == null) {
            return redirect("/register")->with("error", "Something went wrong");
        }
        $user->STATUS += 2; //ini buat toggle active
        $user->EMAIL_VERIFIED_AT = now();
        $user->save();

        DB::delete('delete from user_validation where ID = ?', [
            $uv->ID
        ]);
        //$uv->delete(); hapus verification code

        Auth::login($user);
        if ($user->STATUS == 1) {
            return redirect("buyer")->with("success", "Register Berhasil, Welcome Farmer!");
        } else if ($user->STATUS == 2) {
            return redirect("seller")->with("success", "Register Berhasil, Welcome BeeWorker!");
        }else if ($user->STATUS == 3) {
            return redirect("admin")->with("success", "Register Berhasil, Welcome Admin!");
        }
        return redirect("/")->with("error", "Something went wrong");
    }

    public function ForgotView()
    {
        $route = RouteController::getRouteArray();
        $already = Session::has("success");
        return view("userAuth.forgotpassword", compact("route","already"));
    }
    public function ForgotSend(Request $request)
    {
        $request->validate([
            "email" => ["required",new LoginUsernameRule()]
        ]);

        $email = $request->input("email");
        $user = User::where("EMAIL",$email)->get()->first();
        if($user==null){
            return redirect()->back()->with("error","User not found");
        }
        if($user->STATUS<1){
            return redirect()->back()->with("error","User dalam tahap verifikasi");
        }
        $newkey1 =  UserController::GenerateRandomToken(20);

        $uvalidate = new UserValidation();
        $uvalidate->EMAIL = $request->input("email");
        $uvalidate->EXP_DATE = date_add(now(), date_interval_create_from_date_string("30 days"));
        $uvalidate->STATUS = 2; //forgot password
        $uvalidate->TOKEN = $newkey1;
        $uvalidate->save();

        $route = RouteController::getRouteArray();
        try {
            MailController::forgotPasswordMail($request->input("email"), $user->NAMA, $newkey1);
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Mail failed to send");
        }
        return redirect()->back()->with("success","Request Success, Check your email");
    }

    public function VerifyForgotView($code)
    {
        $uv = UserValidation::where("TOKEN", $code)->get()->first();
        if ($uv == null) {
            return redirect("/")->with("error", "Token not found");
        }
        if ($uv->STATUS != 2) {
            return redirect("/")->with("error", "Looking for something else?");
        }

        $route = RouteController::getRouteArray();
        return view("userAuth.changepassword", compact("route"));
    }

    public function VerifyForgot($code,Request $request)
    {
        $request->validate([
            "password" => ["required"],
            "confirm" => ["required"],
        ]);
        $password = $request->input("password");
        $confirm = $request->input("confirm");
        if($password!=$confirm){
            return redirect()->back()->with("error", "Password dan konfirmasi harus sama");
        }
        //ini untuk verify forgot password
        //cek code valid / gak
        $uv = UserValidation::where("TOKEN", $code)->get()->first();
        $id = UserValidation::where("ID",$uv->ID)->get()->first();
        if ($uv == null) {
            return redirect("/")->with("error", "Token not found");
        }
        if ($uv->STATUS != 2) {
            return redirect("/")->with("error", "Looking for something else?");
        }

        $email = $uv->EMAIL;
        $user = User::where("EMAIL", $email)->get()->first();
        if ($user == null) {
            return redirect("/")->with("error", "Something went wrong");
        }
        $user->PASSWORD = bcrypt($password); //ini buat change password
        $user->save();

        // $id->delete();
        DB::delete('delete from user_validation where ID = ?', [
            $id->ID
        ]);
        Auth::login($user);
        if ($user->STATUS == 1) {
            return redirect("buyer")->with("success", "Change password Berhasil, Welcome Farmer!");
        } else if ($user->STATUS == 2) {
            return redirect("seller")->with("success", "Change password Berhasil, Welcome BeeWorker!");
        }else if ($user->STATUS == 3) {
            return redirect("admin")->with("success", "Change password Berhasil, Welcome Admin!");
        }
        return redirect("/")->with("error", "Something went wrong");
    }
}
