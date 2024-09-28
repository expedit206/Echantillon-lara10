<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */   public function up()
    {
        Schema::create('specialite_unite_de_valeur', function (Blueprint $table) {
            $table->id(); // Clé primaire optionnelle
            $table->unsignedBigInteger('specialite_id');
            $table->unsignedBigInteger('unite_de_valeur_id');

            // Clés étrangères
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('cascade');
            $table->foreign('unite_de_valeur_id')->references('id')->on('unite_de_valeurs')->onDelete('cascade');

            $table->timestamps(); // Optionnel, mais recommandé pour le suivi
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialite_unite_de_valeur');
    }
};
