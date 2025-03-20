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
        Schema::create('producteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom obligatoire
            $table->string('prenom'); // Prénom obligatoire
            $table->enum('genre',["Mr","Mme"]); 
            $table->string('contact', 10)->unique(); // Contact unique et obligatoire
            $table->string('localite'); // Localité obligatoire
            $table->date('naissance'); // Date de naissance obligatoire
            $table->string('images')->nullable(); // Image facultative
            $table->foreignId('id_agent')->constrained("agents")->onDelete('cascade'); // Suppression en cascade
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producteurs');
    }
};