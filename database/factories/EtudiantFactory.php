<?php
namespace Database\Factories;

use App\Models\Annee;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Specialite;
use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $niveaux = Niveau::all();
        $filieres = Filiere::all();
        $annees = Annee::all();
        $specialites = Specialite::all();
        $specialite = $specialites->random();
        $etu = Etudiant::all();
        dump($etu);

        // Choisir des valeurs aléatoires pour les relations
        $annee = $annees->where('is_active', true)->first();

        // Générer le matricule en utilisant la logique que tu as fournie
        $matricule = $this->generateMatricule($specialite->id, $annee->id);

        return [
            'matricule' => $matricule,
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => \Hash::make('aaaaaaaa'), // Utilise le hashage ici

            'dateNaissance' => $this->faker->date,
            'lieuNaiss' => $this->faker->city,
            'numeroTelephone' => $this->faker->phoneNumber,

            'sexe' => $this->faker->randomElement(['Homme', 'Femme']),
            'niveau_id' => $niveaux->random()->id,
            'filiere_id' => $filieres->random()->id,
            'annee_id' => $annee->id,
            'specialite_id' => $specialite->id,
            'created_at' => now(),
            'updated_at' => null,
        ];
    }

    /**
     * Générer le matricule selon la logique spécifiée.
     */
    public function generateMatricule($specialite_id, $annee_id)
    {
        // Obtenir les deux premières lettres de la spécialité
        $specialite = Specialite::find($specialite_id);
        $specialiteCode = strtoupper(substr($specialite->nom, 0, 2));

        // Récupérer l'année active et prendre les deux derniers chiffres
        $annee = Annee::find($annee_id);
        $anneeCode = substr($annee->nom, -2);

        // Compter le nombre d'étudiants dans cette spécialité
        $count = Etudiant::where('specialite_id', $specialite_id)->count() + 1;
        // $etu = Etudiant::where('specialite_id', $specialite_id)->get();
        // dump($etu);
        dump("count : " . $count);
        $numero = str_pad($count, 4, '0', STR_PAD_LEFT);
        dump("num : " . $numero);

        // Générer le matricule complet
        return "CM-ESCa-{$numero}-{$specialiteCode}-{$anneeCode}";
    }
}
