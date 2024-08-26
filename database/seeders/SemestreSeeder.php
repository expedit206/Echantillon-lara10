<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'debut' => '2024-09-01', // Ajuste les dates selon ton calendrier académique
                'fin' => '2025-01-31',
                'is_active' => true,  // Marquer comme actif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Semestre 2',
                'debut' => '2025-02-01',
                'fin' => '2025-06-30',
                'is_active' => false,  // Marquer comme inactif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Ajoute plus de semestres si nécessaire
        ]);
    }
}
