<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Annee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnneesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Annee::insert([
            [
                'nom' => '2023-2024',
                'debut' => Carbon::create('2023', '09', '01'), // 1er septembre 2023
                'fin' => Carbon::create('2024', '06', '30'),   // 30 juin 2024
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => '2024-2025',
                'debut' => Carbon::create('2024', '09', '01'), // 1er septembre 2024
                'fin' => Carbon::create('2025', '06', '30'),   // 30 juin 2025
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
