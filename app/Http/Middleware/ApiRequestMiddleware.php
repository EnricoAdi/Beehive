<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiRequestMiddleware
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
        $token = $request->REMEMBER_TOKEN;
        $checked = User::where("REMEMBER_TOKEN", $token)->get()->first();
        if ($checked == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Unauthorized',
                'data'      => "{}"
            ], 401);
        }
        return $next($request);
    }
}
