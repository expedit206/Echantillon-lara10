<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MonGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard=null): Response
    {
// dd($guard);
        if(Auth::guard($guard)->check()){
            if($guard=='admin'){

            return redirect()->route('dashboard');
            }
            return redirect()->route($guard.'.home');
        }
        return $next($request);
    }
}
