<?php

namespace App\Http\Controllers\Auth\Enseignant;

use App\Models\Annee;
use App\Mail\CodeMail;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Http\Request;
use App\Services\DataService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EnseignantController extends Controller
{

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

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
        $validator = $request->validate([
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
        ], [
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'sexe.required' => 'Le sexe est requis.',
            'sexe.string' => 'Le sexe doit être une chaîne de caractères.',
            'sexe.in' => 'Le sexe doit être soit Masculin, Féminin ou Autre.',
            'dateNaiss.required' => 'La date de naissance est requise.',
            'dateNaiss.date' => 'La date de naissance doit être une date valide.',
            'lieuNaiss.required' => 'Le lieu de naissance est requis.',
            'lieuNaiss.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'lieuNaiss.max' => 'Le lieu de naissance ne doit pas dépasser 255 caractères.',
            'nationalite.required' => 'La nationalité est requise.',
            'nationalite.string' => 'La nationalité doit être une chaîne de caractères.',
            'nationalite.max' => 'La nationalité ne doit pas dépasser 255 caractères.',
            'mobile.required' => 'Le numéro de mobile est requis.',
            'mobile.string' => 'Le numéro de mobile doit être une chaîne de caractères.',
            'mobile.max' => 'Le numéro de mobile ne doit pas dépasser 20 caractères.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'Le fichier doit être de type :values.',
            'photo.max' => 'L\'image ne doit pas dépasser 2048 Ko.',
            'profession.required' => 'La profession est requise.',
            'profession.string' => 'La profession doit être une chaîne de caractères.',
            'profession.max' => 'La profession ne doit pas dépasser 255 caractères.',
            'diplome.required' => 'Le diplôme est requis.',
            'diplome.string' => 'Le diplôme doit être une chaîne de caractères.',
            'diplome.max' => 'Le diplôme ne doit pas dépasser 255 caractères.',
            'salaire.required' => 'Le salaire est requis.',
            'salaire.numeric' => 'Le salaire doit être un nombre.',
            'typeContrat.required' => 'Le type de contrat est requis.',
            'typeContrat.string' => 'Le type de contrat doit être une chaîne de caractères.',
            'typeContrat.max' => 'Le type de contrat ne doit pas dépasser 255 caractères.',
            'debutContrat.required' => 'La date de début du contrat est requise.',
            'debutContrat.date' => 'La date de début du contrat doit être une date valide.',
            'finContrat.date' => 'La date de fin du contrat doit être une date valide.',
            'finContrat.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être une adresse valide.',
            'email.max' => 'L\'adresse e-mail ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);


        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput()->with('status', 'Erreur de validation. Veuillez vérifier les informations.');
        // }

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
            'route'=>'login'
        ];
        $teachers=Enseignant::paginate(20);
        $total=Enseignant::count();

        Mail::to($data['email'])->send(new CodeMail('reucperation du code', $dataMail, 'Admin@gmail.com', 'Administrateur'));
        // Rediriger après l'inscription
        return redirect()->route('teachers')->with('success', 'Enseignant enregistrée avec succès');
            // return view('admin.teachers',
            // array_merge($this->dataService->getAllData(),compact('teachers', 'total')))->with('success', 'Enseignant ajouté avec succès.');
    }

    // Afficher le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }

    // Connexion de l'enseignant
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('enseignant')->attempt($credentials)) {
            // Auth::guard('enseignant') pour spécifier le guard enseignant
            return redirect()->route('enseignant.dashboard');
        }
        die;

        return redirect()->back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.'])->withInput();
    }

    public function destroy(Enseignant $enseignant)
{
    // Rechercher l'enseignant par son ID
     echo $enseignant->id  ;
    $enseignant = Enseignant::find($enseignant->id );
// dd($enseignant);
    // Vérifier si l'enseignant existe
    if (!$enseignant) {
        return redirect()->back()->with('error', 'Enseignant non trouvé.');
    }

    // Supprimer l'enseignant
    $enseignant->delete();

    // Rediriger avec un message de succès
    return redirect()->route('enseignant.login')->with('success', 'Enseignant supprimé avec succès.');
}

    // Fonction de déconnexion pour l'enseignant
    public function logout(Request $request)
    {
        // Déconnecter l'enseignant
        Auth::guard('enseignant')->logout();

        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF pour la sécurité
        $request->session()->regenerateToken();

        // Rediriger vers la page de connexion ou d'accueil après la déconnexion
        return redirect()->route('login')->with('status', 'Vous avez été déconnecté.');
    }

    // Afficher la page d'accueil après connexion

}
