<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            [
                'nom' => 'Niveau 1',
                'created_at' => now(),
            ],
            [
                'nom' => 'BTS',
                'created_at' => now(),
            ],
            [
                'nom' => 'Licence',
                'created_at' => now(),
            ],
            [
                'nom' => 'Master',
                'created_at' => now(),
            ],
        ];

        DB::table('niveaux')->insert($niveaux);
    }
}
