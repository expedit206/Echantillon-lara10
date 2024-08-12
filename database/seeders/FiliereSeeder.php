<?php

namespace Database\Seeders;

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
        DB::table('filieres')->insert([
            ['nom'=>'Genie logiciel','created_at'=>now()],
            ['nom'=>'Kinesitherapie','created_at'=>now()],
            ['nom'=>'Soins infirmier','created_at'=>now()],
            ['nom'=>'Agiculture-elevage','created_at'=>now()],
    ]);
    }
}
