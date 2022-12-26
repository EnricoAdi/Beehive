<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() == null) {
            return redirect()->route('login')->with("error", "You are not authenticated yet");
        } else {
            // $user = Session::get("USER_LOGEDIN");
            $user = Auth::user();
            // $user = $request->cookie(env("SESSIONKEY_USERLOGEDIN"));
            //cek api key is exist
            $checked = User::where("REMEMBER_TOKEN", $user->REMEMBER_TOKEN)->get()->first();
            if ($checked==null) {
                return redirect()->route('login')->with("error", "Token is invalid");
            }
            if($user->STATUS<1){
                return redirect()->route('login')->with("error", "You are not verified yet ◑﹏◐");
            }
            return $next($request);
        }
    }
}
