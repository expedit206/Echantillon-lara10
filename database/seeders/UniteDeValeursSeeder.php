<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UniteDeValeursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unites = [
            ['nom' => 'Mathematiques', 'description' => 'Cours de base en mathématiques', 'credit' => 5, 'created_at' => now(),],
            ['nom' => 'Informatique', 'description' => 'Introduction à la programmation et aux systèmes informatiques', 'credit' => 6, 'created_at' => now(),],
            ['nom' => 'Physique', 'description' => 'Concepts fondamentaux de la physique', 'credit' => 4, 'created_at' => now(),],
            ['nom' => 'Chimie', 'description' => 'Introduction aux principes chimiques', 'credit' => 4, 'created_at' => now(),],
            ['nom' => 'Biologie', 'description' => 'Étude des organismes vivants', 'credit' => 5, 'created_at' => now(),],
            ['nom' => 'Histoire', 'description' => 'Étude des événements passés', 'credit' => 3, 'created_at' => now(),],
            ['nom' => 'Géographie', 'description' => 'Étude des paysages et des régions du monde', 'credit' => 3, 'created_at' => now(),],
            ['nom' => 'Philosophie', 'description' => 'Introduction à la réflexion philosophique', 'credit' => 2, 'created_at' => now(),],
            ['nom' => 'Sociologie', 'description' => 'Étude des sociétés humaines', 'credit' => 3, 'created_at' => now(),],
            ['nom' => 'Économie', 'description' => 'Introduction aux principes économiques', 'credit' => 4, 'created_at' => now(),],
        ];

        DB::table('unite_de_valeurs')->insert($unites);
    }
}
