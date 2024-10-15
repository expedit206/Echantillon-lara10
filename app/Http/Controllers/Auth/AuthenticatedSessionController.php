<?php

namespace App\Http\Controllers\Auth;

use App\Models\Etudiant;
use Illuminate\View\View;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        // student
        dd($request);
        if($request->user_type == 'student'){
            if (Auth::guard('etudiant')->attempt([
                'email' => $request->email,
                'password' => $request->password
                ])) {
                // Si la tentative de connexion est réussie
                return redirect()->intended('etudiant/home');
            }

            // Si l'authentification échoue
            return back()->withErrors([
                'email' => 'Les informations de connexion sont incorrectes.',
            ]);
        }

        // enseignant
        if($request->user_type == 'teacher'){

            if (Auth::guard('enseignant')->attempt([
                'email' => $request->email,
                'password' => $request->password
                ])) {
            // Auth::guard('enseignant') pour spécifier le guard enseignant
            return redirect()->route('enseignant.dashboard');
        } else {
            // Si l'authentification échoue, renvoyer une erreur ou rediriger
            return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();
        }
        }

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
            ])) {
                // Auth::guard('enseignant') pour spécifier le guard enseignant
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
    } else {
        //  die;
        // Si l'authentification échoue, renvoyer une erreur ou rediriger
        return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();
    }


    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()){
        Auth::guard('admin')->logout();
        }

        if (Auth::guard('enseignant')->check()){
        Auth::guard('enseignant')->logout();
        }

        if (Auth::guard('etudiant')->check()){
        Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
