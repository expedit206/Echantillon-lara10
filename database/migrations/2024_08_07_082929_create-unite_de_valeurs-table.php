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
            
            $table->string('nom'); // String nom
            $table->string('description'); // String description
            $table->integer('credit'); // int credit
            $table->primary('nom'); // String nom
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
