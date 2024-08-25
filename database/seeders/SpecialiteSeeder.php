<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Niveau;

class SpecialiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filieres=Niveau::all();
        $specialites=[
             ['nom'=>'Genie logiciel','created_at'=>now(),'filiere_id'=>$filieres->random()->id],
             ['nom'=>'Kinesitherapie','created_at'=>now(),'filiere_id'=>$filieres->random()->id],
             ['nom'=>'Soins infirmier','created_at'=>now(),'filiere_id'=>$filieres->random()->id],
             ['nom'=>'Agiculture-elevage','created_at'=>now(),'filiere_id'=>$filieres->random()->id],
     ];
 
 
     \DB::table('specialites')->insert($specialites);
 
    }
}
