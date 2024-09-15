<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function create(): View
    {
        return view('auth.admin.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOMEADMIN);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        // Déconnecter l'enseignant
        Auth::guard('admin')->logout();
// die;
        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF pour la sécurité
        $request->session()->regenerateToken();

        // Rediriger vers la page de connexion ou d'accueil après la déconnexion
        return redirect()->route('admin.login')->with('status', 'Vous avez été déconnecté.');
    }
}
