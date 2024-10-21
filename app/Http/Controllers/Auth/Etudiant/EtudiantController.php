<?php

namespace App\Http\Controllers\Auth\Etudiant;

use App\Models\Annee;
use App\Mail\CodeMail;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Specialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EtudiantController extends Controller
{

    protected $redirectTo = '/home';
    public $data;
    public function __construct(DataService $dataService)
    {
        $this->middleware('guest')->except('logout');
        $this->dataService = $dataService;
    }

        public function showRegister()
        {
               $filieres = DB::table('filieres')->get();
               $niveaux = DB::table('niveaux')->get();
               $annees=Annee::all();
            return view('auth.etudiant.register',$this->dataService->getAllData());
        }

        public function register(Request $request)
        {
            // Validation des données
            $this->data = $request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'sexe' => ['required', 'string'],
                'dateNaissance' => ['required', 'date'],
                'lieuNaiss' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:etudiants'],
                'numeroTelephone' => ['required', 'numeric', 'min:8', 'unique:etudiants'],
                'niveau_id' => ['required', 'string'],
                'filiere_id' => ['required', 'string', 'max:255'],
                'specialite_id' => ['required', 'string', 'max:255'],
            ]);
        
            // Récupérer l'année académique active
            $this->data['annee_id'] = Annee::where('is_active', true)->first()->id;
        
            // Définir un mot de passe par défaut haché
            $this->data['password'] = Hash::make('00000000');
        
            // Générer un matricule unique
            $this->data['matricule'] = $this->generateMatricule($this->data['specialite_id']);
        
            // Créer l'étudiant
            // dd($this->data);
            Etudiant::create($this->data);
        
            // Envoyer l'email de bienvenue avec le matricule et le mot de passe
            $dataMail = [
                'title' => "Bienvenue " . $this->data['nom'] . " " . $this->data['prenom'],
                'message' => "Connectez-vous au site avec votre email et votr mot de passe par défaut ",
                'matricule' => $this->data['matricule'],
                'password' => '00000000',
                'email' => $this->data['email'],
                'route' => route('login'),
                'type' => 'student'
            ];
            $students = Etudiant::whereRelation('annee', 'is_active', true)->paginate(20);
            // dd($students);
            $total = $students->count();
            Mail::to($this->data['email'])->send(new CodeMail('votre lien de connexion', $dataMail, 'Admin@gmail.com', 'Administrateur'));
        // die;
            // return redirect()->route('etudiant.login')   ->with('success', 'Inscription réussie !');
            return redirect()->route('students')->with('success', 'Inscription réussie !') ;;
            // return view('admin.students', array_merge([
            //     // 'search' => $search,
            //     'students' => $students,
            //     'total' => $total,
            // ], $this->dataService->getAllData()))->with('success', 'Inscription réussie !') ;
        }
        

        public function generateMatricule($specialite_id)
{
    // Obtenir les deux premières lettres de la filière (ex. 'SA' pour 'Sciences Appliquées')
    $specialite = Specialite::find($specialite_id);
    $specialiteCode = strtoupper(substr($specialite->nom, 0, 2));

    // Récupérer l'année active et prendre les deux derniers chiffres de l'année
    $annee = Annee::where('is_active', true)->first();
    $anneeCode = substr($annee->nom, -2);  // '22' pour l'année 2022-2023

    // Compter le nombre d'étudiants déjà inscrits dans cette filière pour générer un numéro incrémenté
    $count = Etudiant::where('specialite_id', $specialite_id)->count() + 1;
    // dd($specialite_id);
    $numero = str_pad($count, 4, '0', STR_PAD_LEFT);  // Générer un numéro à 4 chiffres

    // Générer le matricule complet
    $matricule = "CM-ESCa-{$numero}-{$specialiteCode}-{$anneeCode}";

    return $matricule;
}



        public function showLogin($email=null, $password=null)
        {
            return view('auth.etudiant.login',['password'=>$password,'email'=>$email]);
         }



         public function login(Request $request)
         {

            $credentials=$request->validate([
                'code' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255']
            ]);
        $existEtudiant= Etudiant::where('email',$credentials['email'])->where('code',$credentials['code'])->first();
            if($existEtudiant){
                Auth::guard('etudiant')->login($existEtudiant);
            return redirect()->intended('etudiant/home');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
}

public function edit(Etudiant $student)
{
    $annees=Annee::all();
    $filieres = DB::table('filieres')->get();
    $niveaux = DB::table('niveaux')->get();
    $specialites = DB::table('specialites')->get();
    // dd($student->id);
   return view('etudiant.edit', compact('annees','filieres','niveaux','student','specialites'));
}

public function update(Request $request, $student)
{
    // Validation des données du formulaire
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'dateNaissance' => 'required|date',
        'lieuNaiss' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telephone' => 'required|string|max:15',
        'sexe' => 'required|string',
        'niveau_id' => 'required|integer|exists:niveaux,id',
        'filiere_id' => 'required|integer|exists:filieres,id',
        'specialite_id' => 'required|integer|exists:specialites,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Récupérer l'étudiant existant
    $student = Etudiant::findOrFail($student);

    // Mise à jour des informations de l'étudiant
    $student->nom = $request->nom;
    $student->prenom = $request->prenom;
    $student->dateNaissance = $request->dateNaissance;
    $student->lieuNaiss = $request->lieuNaiss;
    $student->email = $request->email;
    $student->numeroTelephone = $request->telephone;
    $student->sexe = $request->sexe;
    $student->niveau_id = $request->niveau_id;
    $student->filiere_id = $request->filiere_id;
    $student->specialite_id = $request->specialite_id;

    // Gestion de la photo si elle est présente
    if ($request->hasFile('photo')) {
        $filePath = $request->file('photo')->store('photos', 'public');
        $student->photo = $filePath;
    }

    // Sauvegarde des changements
    $student->save();

    // Redirection avec un message de succès
    return redirect()->route('student.show', $student->id)->with('success', 'Les informations de l\'étudiant ont été mises à jour avec succès.');
}

public function logout()
{
    Auth::guard('etudiant')->logout();
    return redirect()->back();
}

}
