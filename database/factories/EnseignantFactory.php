<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Enseignant;
use App\Models\UniteValeur;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Récupérer un nom d'unité de valeur aléatoire pour la clé étrangère
        $uniteValeur = UniteValeur::inRandomOrder()->first();
        $annees = Annee::all();

        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(['Masculin', 'Féminin', 'Autre']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Vous pouvez utiliser Hash::make('password') aussi
            'dateNaiss' => $this->faker->date(),
            'lieuNaiss' => $this->faker->city,
            'nationalite' => $this->faker->country,
            'mobile' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(),
            'profession' => $this->faker->jobTitle,
            'diplome' => $this->faker->word,
            'annee_id' => $annees->random()->id, // Référence à une filière existante ou générée
            'salaire' => $this->faker->randomFloat(2, 2000, 10000),
            'typeContrat' => $this->faker->randomElement(['CDI', 'CDD', 'Intérim', 'Stage', 'Autre']),
            'debutContrat' => $this->faker->date(),
            'finContrat' => $this->faker->optional()->date(),
        ];
    }
}
