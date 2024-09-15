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
        public function handle(Request $request, Closure $next,$guard=null): Response
        {
        \Log::info('session'.session()->get('last_logged_out_user_type'));
        $lastLoggedOutUserType = session()->get('last_logged_out_user_type');

        if ($lastLoggedOutUserType==$guard) {
            session()->forget('last_logged_out_user_type');
            return redirect()->route($guard.'.login');
        }

        // return $request->expectsJson() ? null : route($guard.'.login');

        return $next($request);
    }
}
