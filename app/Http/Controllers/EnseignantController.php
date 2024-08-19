<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index(Request $request)
    {

        $teachers =Enseignant::latest()->paginate(15);
        // dd($teachers);
// dd($request);
        if($request['search'] || $request['niveau'] || $request['filiere'] || $request['anciennete']){
            $search=$request['search'];
            // dd($request);
            $filiere= Filiere::where('nom',$request['filiere'])->first()??  "";
            $niveau=Niveau::where('nom', $request['niveau'])->first()?? "";

            // dd($filiere );
            $anciennete=$request['anciennete'];
// dd($filiere->nom);
            switch($anciennete){
                case 'Plus recent':
                    // dd($filiere );
                    $teachers = Enseignant::orderBy('created_at', 'desc')
                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                          ->when($niveau, function($query) use ($niveau){

                            return $query->where('idNiveau', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('idFiliere', $filiere->id);
                        })

                        ->latest()->paginate(10);
                        break;
                case 'Moins recent':

                    $teachers = Enseignant::orderBy('created_at', 'asc')
                  -> where(function ($query) use ($search){
                        $query->where('nom','like','%' .$search. '%')
                        ->orWhere('prenom','like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                         })
                         ->when($niveau, function($query) use ($niveau){

                            return $query->where('idNiveau', $niveau->id);
                        })
                        ->when($filiere, function($query) use ($filiere){

                            return $query->where('idFiliere', $filiere->id);
                        })

                        ->latest()->paginate(10);
                        break;

                        case 'A à Z':
                            $teachers = Enseignant::orderBy('nom', 'asc')
                          -> where(function ($query) use ($search){
                                $query->where('nom','like','%' .$search. '%')
                                ->orWhere('prenom','like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                                 })
                                 ->when($niveau, function($query) use ($niveau){

                                    return $query->where('idNiveau', $niveau->id);
                                })
                                ->when($filiere, function($query) use ($filiere){

                                    return $query->where('idFiliere', $filiere->id);
                                })
                                ->latest()->paginate(10);
                        break;
                        case 'Z à A':
                            $teachers = Enseignant::orderBy('nom', 'desc')
                          -> where(function ($query) use ($search){
                                $query->where('nom','like','%' .$search. '%')
                                ->orWhere('prenom','like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                                 })
                                 ->when($niveau, function($query) use ($niveau){

                                    return $query->where('idNiveau', $niveau->id);
                                })
                                ->when($filiere, function($query) use ($filiere){

                                    return $query->where('idFiliere', $filiere->id);
                                })
                                ->latest()->paginate(10);
                        break;

             }


                            }

            $total = $teachers->count();
            $search=$request?->search;

        $filieres = Filiere::orderBy('created_at', 'desc')->get();
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        return view('admin.teachers', compact('teachers','total','search','niveaux','filieres'));
     }

     public function teachersByFiliere(Filiere $filiere)
     {

         $teachers = Enseignant::where('idFiliere', $filiere->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',compact('teachers','total','niveaux','filieres'));
        }



     public function teachersByNiveau(Niveau $niveau)
     {
         $teachers = Enseignant::where('idNiveau', $niveau->id)->latest()->paginate(15);
        $niveaux = Niveau::orderBy('created_at', 'desc')->get();
        $filieres = Filiere::orderBy('created_at', 'desc')->get();

         $total = $teachers->count();
         return view('admin.teachers',compact('teachers','total','niveaux','filieres'));
        }
}
