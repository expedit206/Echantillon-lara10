<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'role' => 'admin',
                'nom' => 'expedit',
                'prenom' => 'dominique',
                'email' => 'expedit@gmail.com',
                'motDePasse' => Hash::make('123456789'), // Assurez-vous de hacher les mots de passe
                'created_at'=>now()
            ]
        ]);
    
}
}