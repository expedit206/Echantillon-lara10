<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'nom' => 'UE Fondamentales',
                'pourcentage' => 30, // Assurez-vous d'avoir cette colonne dans votre table si vous utilisez les pourcentages
            ],
            [
                'nom' => 'UE Professionnelles',
                'pourcentage' => 60,
            ],
            [
                'nom' => 'UE Transversales',
                'pourcentage' => 10,
            ],
        ]);
    }
}
