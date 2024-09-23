<?php

namespace App\Http\Controllers\Auth\Etudiant;

use App\Mail\CodeMail;
use App\Models\Etudiant;
use App\Models\Annee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EtudiantController extends Controller
{

    protected $redirectTo = '/home';
    public $data;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // $this->middleware('guest')->only('showRegister');
    }

        public function showRegister()
        {
               $filieres = DB::table('filieres')->get();
               $niveaux = DB::table('niveaux')->get();
               $annees=Annee::all();
            return view('auth.etudiant.register',compact('filieres', 'niveaux','annees'));
        }

        public function register(Request $request)
        {

            $this->data=$request->validate([
                'password'=>['string'],
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'sexe' => ['required', 'string'],
                'dateNaissance' => ['required', 'date'],
                'lieuNaiss' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:etudiants'],
                'telephone' => ['required', 'numeric','min:8', 'unique:etudiants'],
                'niveau_id' => ['required', 'string'],
                'filiere_id' => ['required', 'string', 'max:255'],
                // 'annee_id' => 'required|exists:annees,id',
            ]);

            $this->data['annee_id']=Annee::where('is_active', true)->first()->id;


            $this->data['password']=$this->genearateCode();

            etudiant::create($this->data);

            // envoie du mail contenant le code
            $dataMail=[
                'title'=>"Bienvenue ". $this->data['nom'] ." ".  $this->data['prenom'],
                'message'=>"Connecter vous au site avec votre code",
                'password'=>$this->data['password'],
                'email'=>$this->data['email'],
                'route'=>$this->data['route'],
            ];

            Mail::to($this->data['email'])->send(new CodeMail('reucperation du password', $dataMail, 'Admin@gmail.com', 'Administrateur'));
            return redirect()->route('etudiant.login',['password'=>null,'email'=>null])->with('status', 'Inscription reussie !!!');
        }

        public function genearateCode()
        {
            do{
                $code = Str::upper(Str::random(4));

            }while(Etudiant::where('password', $this->data['password'])->exists() );
            return $code;
         }


        public function showLogin($email=null, $code=null)
        {
            return view('auth.login',['password'=>$code,'email'=>$email]);
         }



         public function login(Request $request)
         {

            $credentials=$request->validate([
                'password' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255']
            ]);
        $existEtudiant= Etudiant::where('email',$credentials['email'])->where('password',$credentials['password'])->first();
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
