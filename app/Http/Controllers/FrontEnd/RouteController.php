<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\Session;

class RouteController extends Controller
{

    public function getRole($status){
        //function ini untuk mereturn role dalam string
        $role = "";
        if($status==1){
            $role = "Buyer";
        }
        if($status==2){
            $role = "Seller";
        }
        if($status==3){
            $role = "Admin";
        }
        if($status==0){
            $role = "Not Verified";
        }
        return [$status,$role];
    }
    public static function getRouteArray()
    {
        /** Function static ini untuk returnkan routing dalam bentuk array */
        $uri = explode("/",FacadesRoute::current()->uri);
        return $uri;
    }
    public static function includeRouting($compare){
        /** Function static ini untuk cek apakah routing ini mengandung keyword compare */
        $uri = explode("/",FacadesRoute::current()->uri);
        if(in_array($compare,$uri)){
            return true;
        }
        return false;
    }
    public function dummy()
    {
        $user = Auth::user();
        $role = $this->getRole($user->STATUS);
        // dd($role);

        return view("dummy", compact("role"));
    }
}
