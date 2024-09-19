<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MonAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
        */
        public function handle(Request $request, Closure $next): Response
        {
            if(!Auth::guard('enseignant')->check() && !Auth::guard('etudiant')->check()){

                return redirect()->route('login');

            }
           

        // return $request->expectsJson() ? null : route($guard.'.login');

        return $next($request);
    }
}
