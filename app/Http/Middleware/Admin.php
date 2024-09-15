<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */



     public function handle(Request $request, Closure $next): Response
     {
        if(!\Auth::guard('admin')->check()){
        return redirect()->route('admin.login');
    }
    return $next($request);

    }
}
