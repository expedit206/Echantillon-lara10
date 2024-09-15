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
        Schema::create('enseignant_filiere', function (Blueprint $table) {
            $table->foreignId('enseignant_id')->constrained('enseignants')->onUpdate('cascade')->onDelete('cascade'); // int idenseignant
            $table->foreignId('filiere_id')->constrained('filieres')->onUpdate('cascade')->onDelete('cascade'); // int idFiliere
            
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
