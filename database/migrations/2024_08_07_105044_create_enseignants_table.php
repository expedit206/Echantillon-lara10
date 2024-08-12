<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id(); // id
            $table->string('nom'); // String nom
            $table->string('prenom'); // String prenom
            $table->string('email')->unique(); // String email
            $table->string('password'); // String mdpPasse
            $table->string('uniteValeur'); // idUniteValeur doit être du même type que la clé primaire dans niveaux
            $table->foreign('uniteValeur')->references('nom')->on('unite_de_valeurs')->onUpdate('cascade');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
