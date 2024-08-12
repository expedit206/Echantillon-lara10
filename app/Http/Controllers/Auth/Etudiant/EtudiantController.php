<?php

namespace App\Http\Controllers\Auth\Etudiant;

use App\Mail\CodeMail;
use App\Models\Etudiant;
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
            return view('auth.etudiant.register',compact('filieres', 'niveaux'));
        }

        public function register(Request $request)
        {

            $this->data=$request->validate([
                'code'=>['string'],
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'sexe' => ['required', 'string'],
                'dateNaissance' => ['required', 'date'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:etudiants'],
                'telephone' => ['required', 'numeric','min:8', 'unique:etudiants'],
                'idNiveau' => ['required', 'string'],
                'idFiliere' => ['required', 'string', 'max:255'],
            ]);

            $existFiliere= DB::table('filieres')->where('nom', $request->idFiliere)->first();
            $existNiveau= DB::table('niveaux')->where('nom', $request->idNiveau)->first();
            $idfiliere=$existFiliere?->id;
            $idniveau=$existNiveau?->id;
            // dd($idfiliere);
            if(!$existFiliere){
               $idfiliere= DB::table('filieres')->insertGEtId([
                    "nom"=>$request->idFiliere,
                    "created_at"=>now(),
                    "updated_at"=>now(),
                ]);

            }
            $this->data['idFiliere']=$idfiliere;

            if(!$existNiveau){
               $idniveau= DB::table('Niveaux')->insertGEtId([
                    "nom"=>$request->idNiveau,
                    "created_at"=>now(),
                    "updated_at"=>now(),
                ]);

            }
            $this->data['idNiveau']=$idniveau;


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
            // dd($credentials);
// $existEtudiant= Etudiant::where('email','mciani@gmail.com')->where('code','COQV')->first();
$existEtudiant= Etudiant::where('email',$credentials['email'])->where('code',$credentials['code'])->first();
        // Authentifier avec le guard 'etudiant'
        // if (Auth::guard('etudiant')->attempt($credentials)) {
            if($existEtudiant){
                Auth::guard('etudiant')->login($existEtudiant);
            return redirect()->intended('etudiant/home');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
}

public function home()
    {
   return view('etudiant.home');
    }
}
