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

class LoginController extends Controller
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
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

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
