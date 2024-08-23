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
        Schema::create('unite_de_valeurs', function (Blueprint $table) {

            $table->id(); // String nom

            $table->string('nom')->unique(); // String nom, unique
            $table->string('description'); // String description
            $table->integer('credit'); // int credit
            $table->foreignId('enseignant_id')->contrained(); // String nom, unique
            $table->foreignId('filiere_id')->contrained(); // String nom, unique
            $table->timestamps(); // created_at et updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unite_de_valeurs');
    }
};
