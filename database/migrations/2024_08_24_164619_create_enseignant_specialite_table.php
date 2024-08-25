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
        Schema::create('enseignant_specialite', function (Blueprint $table) {
           
            $table->foreignId('enseignant_id')->constrained('enseignants')->onUpdate('cascade'); // int idenseignant
            $table->foreignId('specialite_id')->constrained('specialites')->onUpdate('cascade'); // int idNiveau
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_specialite');
    }
};
