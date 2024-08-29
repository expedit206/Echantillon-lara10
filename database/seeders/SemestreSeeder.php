<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('semestres')->insert([
            [
                'nom' => 'Semestre 1',
                'annee_id' => 1, // Assumes that the année with id 1 exists
                'debut' => '2024-09-01',
                'fin' => '2025-01-31',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Semestre 2',
                'annee_id' => 1, // Assumes that the année with id 1 exists
                'debut' => '2025-02-01',
                'fin' => '2025-06-30',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Ajoute plus de semestres si nécessaire
        ]);

    }
}
