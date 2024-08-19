<?php

namespace App\Http\Controllers\Auth\Enseignant;

use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EnseignantController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegister()
    {
        $unite_de_valeurs = UniteValeur::all(); // Récupère toutes les unités de valeur
        return view('auth.enseignant.register', compact('unite_de_valeurs'));
    }

    // Inscrire un nouvel enseignant
    public function register(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string|in:Masculin,Féminin,Autre',
            'dateNaiss' => 'required|date',
            'lieuNaiss' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profession' => 'required|string|max:255',
            'diplome' => 'required|string|max:255',
            'salaire' => 'required|numeric',
            'typeContrat' => 'required|string|max:255',
            'debutContrat' => 'required|date',
            'finContrat' => 'nullable|date|after_or_equal:debutContrat',
            'uniteValeur' => 'required|string|exists:unite_de_valeurs,nom',
            'email' => 'required|string|email|max:255|unique:enseignants',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            // dump($validator);
            // die;
            return redirect()->back()->withErrors($validator)->withInput()->with('status', 'Erreur de validation. Veuillez vérifier les informations.');
            ;
        }

        // Gérer le téléchargement de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Créer un nouvel enseignant
        Enseignant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'dateNaiss' => $request->dateNaiss,
            'lieuNaiss' => $request->lieuNaiss,
            'nationalite' => $request->nationalite,
            'mobile' => $request->mobile,
            'photo' => $photoPath,
            'profession' => $request->profession,
            'diplome' => $request->diplome,
            'salaire' => $request->salaire,
            'typeContrat' => $request->typeContrat,
            'debutContrat' => $request->debutContrat,
            'finContrat' => $request->finContrat,
            'uniteValeur' => $request->uniteValeur,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Rediriger après l'inscription
        return redirect()->route('enseignant.login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    // Afficher le formulaire de connexion
    public function showLogin()
    {
        return view('auth.enseignant.login');
    }

    // Connexion de l'enseignant
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('enseignant')->attempt($credentials)) {
            // Auth::guard('enseignant') pour spécifier le guard enseignant
            return redirect()->route('enseignant.home');
        }

        return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();
    }

    // Afficher la page d'accueil après connexion
    public function home()
    {
        return view('enseignant.home');
    }
}
