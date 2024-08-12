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
        Schema::create('enseignant-filiere', function (Blueprint $table) {
            $table->foreignId('idEnseignant')->constrained('enseignants')->onUpdate('cascade'); // int idenseignant
            $table->foreignId('idFiliere')->constrained('filieres')->onUpdate('cascade'); // int idFiliere
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_filiere');
    }
};
