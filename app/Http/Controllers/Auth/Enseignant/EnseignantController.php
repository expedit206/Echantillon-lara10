<?php

namespace App\Http\Controllers\Auth\Enseignant;

use App\Models\Annee;
use App\Mail\CodeMail;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EnseignantController extends Controller
{
    // Afficher le formulaire d'inscription
    public function create()
    {
        $unite_de_valeurs = UniteValeur::all(); // Récupère toutes les unités de valeur
        $annees = Annee::all(); // Récupère toutes les unités de valeur
        return view('auth.enseignant.create', compact('unite_de_valeurs','annees'));
    }

    // Inscrire un nouvel enseignant
    public function store(Request $request)
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
            'email' => 'required|string|email|max:255|unique:enseignants',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('status', 'Erreur de validation. Veuillez vérifier les informations.');
        }

        // Gérer le téléchargement de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Créer un nouvel enseignant
        $annee_id=Annee::where('is_active',true)->first()->id;

       $data= Enseignant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'dateNaiss' => $request->dateNaiss,
            'lieuNaiss' => $request->lieuNaiss,
            'nationalite' => $request->nationalite,
            'mobile' => $request->mobile,
            'annee_id' => $annee_id,
            'photo' => $photoPath,
            'profession' => $request->profession,
            'diplome' => $request->diplome,
            'salaire' => $request->salaire,
            'typeContrat' => $request->typeContrat,
            'debutContrat' => $request->debutContrat,
            'finContrat' => $request->finContrat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
           // envoie du mail contenant le code
           $dataMail=[
            'title'=>"Bienvenue Monsieur ". $data['nom'] ." ".  $data['prenom'],
            'message'=>"Connecter vous au site avec votre mot de passe",
            'password'=>$request->password,
            'email'=>$data['email'],
            'route'=>'enseignant.login'
        ];
        
        Mail::to($data['email'])->send(new CodeMail('reucperation du code', $dataMail, 'Admin@gmail.com', 'Administrateur'));
        // Rediriger après l'inscription
        return redirect()->route('enseignant.login')->with('success', 'Enseignant ajouté avec succès.');
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
            return redirect()->route('enseignant.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();
    }

    public function destroy(Enseignant $enseignant)
{
    // Rechercher l'enseignant par son ID
     echo $enseignant;
    $enseignant = Enseignant::find($enseignant);
dd($enseignant);
    // Vérifier si l'enseignant existe
    if (!$enseignant) {
        return redirect()->back()->with('error', 'Enseignant non trouvé.');
    }

    // Supprimer l'enseignant
    $enseignant->delete();

    // Rediriger avec un message de succès
    return redirect()->route('enseignant.index')->with('success', 'Enseignant supprimé avec succès.');
}

    // Afficher la page d'accueil après connexion

}
