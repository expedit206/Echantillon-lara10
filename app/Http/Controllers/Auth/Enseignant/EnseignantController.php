<?php

namespace App\Http\Controllers\Auth\Enseignant;

use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // $this->middleware('guest')->only('showRegister');
    }

        public function showRegister()
        {
               $unite_de_valeurs = DB::table('unite_de_valeurs')->get();
            return view('auth.enseignant.register',compact('unite_de_valeurs'));
        }

        protected function register(Request $request)
        {
            $unite_de_valeur = DB::table('unite_de_valeurs')->where('nom', $request->uniteValeur)->first();
            if(!$unite_de_valeur){
                DB::table('unite_de_valeurs')->insert([
                    'nom' => $request->uniteValeur,
                    'description' => $request->uniteValeur,
                    'credit' => 1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
                $unite_de_valeur = DB::table('unite_de_valeurs')->where('nom', $request->UniteValeur)->first();
                // die;
            }

            $data=$request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'uniteValeur' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data['password'] = Hash::make($data['password']);

            Enseignant::create($data);
            return redirect()->route('enseignant.login')->with('status', 'Inscription reussie !!!');
        }

        public function showLogin()
        {
            return view('auth.enseignant.login');
         }



         public function login(Request $request)
         {
            // dd($request);
            $credentials = $request->only('email', 'password');
// dd($credentials);
        // Authentifier avec le guard 'enseignant'
        // if (Auth::guard('enseignant')->attempt($credentials)) {
            if(Auth::guard('enseignant')->attempt($credentials)){
                $request->session()->regenerate();

            return redirect()->intended('RouteServiceProvider::HOMETEACHER');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
}

public function home()
    {
   return view('enseignant.home');
    }
}
