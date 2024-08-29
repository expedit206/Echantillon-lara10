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
        Schema::create('semestres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('annee_id')->constrained('annees')->onDelete('cascade');
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
