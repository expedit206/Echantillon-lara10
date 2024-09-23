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
        if($request->user_type == 'student'){
            $existEtudiant= Etudiant::where('email',$request['email'])->where('password',$request['password'])->first();
            if($existEtudiant){
                Auth::guard('etudiant')->login($existEtudiant);
            return redirect()->intended('etudiant/home');
            }

        return back()->withErrors([ 
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
            // dd($request->user_type);
        }

        // enseignant
        if($request->user_type == 'teacher'){
            $existEnseignant= Enseignant::where('email',$request['email'])->where('password',$request['password'])->first();

            if($existEnseignant){

            Auth::guard('enseignant')->login($existEnseignant) ;
                // Auth::guard('enseignant') pour spécifier le guard enseignant
                return redirect()->route('enseignant.dashboard');
            
        }
    
    return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();


        }


        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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
}
