<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\NoteSeeder;
use Database\Seeders\EnseignantSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            AnneesSeeder::class,
            AdminSeeder::class,
            FiliereSeeder::class,
            NiveauSeeder::class,
            UniteDeValeursSeeder::class,
            EtudiantsSeeder::class,
            EnseignantSeeder::class,
            NoteSeeder::class
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
