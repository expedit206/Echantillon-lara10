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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
            $table->foreignId('unite_valeur_id')->constrained()->onDelete('cascade');
            $table->decimal('note', 5, 2); // Stocke la note avec 2 décimales, par exemple, 95.50
            $table->enum('type', ['Controle continu', 'Normale','Rattrapage'])->default('Controle continu');
            $table->foreignId('enseignant_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
