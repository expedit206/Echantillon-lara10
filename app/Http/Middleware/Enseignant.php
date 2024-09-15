<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Enseignant
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */



     public function handle(Request $request, Closure $next): Response
     {
        if(!\Auth::guard('enseignant')->check()){
        return redirect()->route('enseignant.login');
    }
    return $next($request);

    }
}
