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
        Schema::create('specialite_unite_de_valeur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialite_id')->constrained()->onDelete('cascade');
            $table->foreignId('unite_de_valeur_id')->constrained('unite_de_valeurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialite_unite_de_valeur');
    }
};
