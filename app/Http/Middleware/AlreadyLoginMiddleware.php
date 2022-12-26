<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlreadyLoginMiddleware
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
            return $next($request);
        } else {
            $user = Auth::user();
            if($user->STATUS==2){
                return redirect()->route("dashboardSeller")->with("error", "You have already login");
            }
            else if($user->STATUS==1){
                return redirect()->route("buyer")->with("error", "You have already login");
            }else if($user->STATUS==3){
                return redirect()->route("admin")->with("error", "You have already login");
            }else{
                return redirect("/")->with("error", "Something went wrong (not verified yet) err $user->STATUS");

            }
        }
    }
}
