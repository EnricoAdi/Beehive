<?php

namespace App\Http\Middleware;

use App\Models\Logging;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as FacadesRoute;

class LoggingMiddleware
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
        $response = $next($request);
        $user = Auth::user();
        if ($user != null) {
            $uri = explode("/", FacadesRoute::current()->uri);
            if (!in_array("download", $uri)) {
                $logging = new Logging();
                $logging->IP = $request->ip();
                $logging->URL = $request->url();
                $logging->STATUS_CODE = $response->status();
                $logging->EMAIL = $user->EMAIL;
                $logging->save();
            }
        }

        return $response;
    }
}
