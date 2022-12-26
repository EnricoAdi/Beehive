<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public static function LandingPage()
    {
        $user = "";
        $toApp = "";
        if (Auth::user() != null) {
            $user = Auth::user();
            if ($user->STATUS == 1) {
                $toApp = "/buyer";
            }
            else if ($user->STATUS == 2) {
                $toApp = "/seller";
            }
            else if ($user->STATUS == 3) {
                $toApp = "/admin";
            }else {
                $toApp = "/";
            }
        }
        return view("landingpage", compact("user","toApp"));
    }
}
