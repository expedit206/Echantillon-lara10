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
                'code'=>['string'],
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


            $this->data['code']=$this->genearateCode();

            etudiant::create($this->data);

            // envoie du mail contenant le code
            $dataMail=[
                'title'=>"Bienvenue ". $this->data['nom'] ." ".  $this->data['prenom'],
                'message'=>"Connecter vous au site avec votre code",
                'code'=>$this->data['code'],
                'email'=>$this->data['email']
            ];

            Mail::to($this->data['email'])->send(new CodeMail('reucperation du code', $dataMail, 'Admin@gmail.com', 'Administrateur'));
            return redirect()->route('etudiant.login',['code'=>null,'email'=>null])->with('status', 'Inscription reussie !!!');
        }

        public function genearateCode()
        {
            do{
                $code = Str::upper(Str::random(4)); 

            }while(Etudiant::where('code', $this->data['code'])->exists() );
            return $code;
         }


        public function showLogin($email=null, $code=null)
        {
            return view('auth.etudiant.login',['code'=>$code,'email'=>$email]);
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
    // dd($student->id);
   return view('etudiant.edit', compact('annees','filieres','niveaux','student'));
}
public function logout()
{
    Auth::guard('etudiant')->logout();
    return redirect()->back();
}

}
