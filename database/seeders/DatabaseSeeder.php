<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\NoteSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\AnneesSeeder;
use Database\Seeders\NiveauSeeder;
use Database\Seeders\FiliereSeeder;
use Database\Seeders\EtudiantSeeder;
use Database\Seeders\SemestreSeeder;
use Database\Seeders\EnseignantSeeder;
use Database\Seeders\specialiteSeeder;
use Database\Seeders\UniteDeValeursSeeder;

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
            // FiliereSeeder::class,
            // NiveauSeeder::class,
            SemestreSeeder::class,
            EnseignantSeeder::class,
            // UniteDeValeursSeeder::class,
            EtudiantSeeder::class,
            NoteSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
