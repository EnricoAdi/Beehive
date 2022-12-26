<?php

namespace App\Models;

use App\Http\Controllers\BackEnd\UserController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table="user";

    public $primaryKey = "EMAIL";

    protected $keyType = 'string';
    public $timestamps = true;
    //ini buat mass assignment
    protected $fillable = ["NAMA","EMAIL","SUBSCRIBED","PASSWORD","TANGGAL_LAHIR","STATUS", "REMEMBER_TOKEN","PICTURE"];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //ini buat default value
    protected $attributes = [
        "BALANCE" => 0,
        "BIO" => 0,
        "RATING" => 0,
    ];

    public function Store()
    {
        Session::put("USER_LOGEDIN",$this);
    }
    public function getRole(){
        //function ini untuk mereturn role dalam string
        $role = "";
        if($this->STATUS==1){
            $role = "Buyer";
        }
        if($this->STATUS==2){
            $role = "Seller";
        }
        if($this->STATUS==3){
            $role = "Admin";
        }
        if($this->STATUS==0){
            $role = "Not Verified";
        }
        return [
            "Status" => $this->STATUS,
            "Role" => $role
        ];
    }
    static public function Unstore(){
        // $request->session()->forget('key');("USER_LOGEDIN",$this);
        // Session::forget("USER_LOGEDIN");

        Auth::logout();
    }

    //define relations here
    public function topup(){
        return $this->hasMany(TopUp::class,"EMAIL","EMAIL");
    }

    public function validation(){
        return $this->hasMany(UserValidation::class,"EMAIL","EMAIL");
    }

    public function stings(){
        return $this->hasMany(Sting::class,"EMAIL_BEEWORKER","EMAIL");
    }

}

