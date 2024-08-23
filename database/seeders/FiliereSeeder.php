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
            ['nom'=>'Genie logiciel','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Kinesitherapie','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Soins infirmier','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
            ['nom'=>'Agiculture-elevage','created_at'=>now(),'niveau_id'=>$niveaux->random()->id],
    ];


    DB::table('filieres')->insert($filieres);

    }
}
