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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom obligatoire
            $table->string('prenom'); // Prénom obligatoire
            $table->enum('genre', ["Mr", "Mme"]); // Genre obligatoire
            $table->string('email')->unique(); // Email unique
            $table->string('contact', 10)->unique(); // Contact unique et obligatoire
            $table->string('password'); // Mot de passe
            $table->string('images')->nullable(); // Image facultative
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
