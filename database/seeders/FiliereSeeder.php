<?php

namespace Database\Seeders;

use App\Models\Niveau;
use App\Models\Filiere;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux=Niveau::all();
       $filieres=[
            ['nom'=>'Agriculture et elevage','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Genie informatique','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Economie sociale et familiale','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Sante','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Gestion','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Genie civil','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
    ];


    DB::table('filieres')->insert($filieres);

    }
}
