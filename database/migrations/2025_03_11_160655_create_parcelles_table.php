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
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('superficie');
            $table->float('latitude');
            $table->float('longitude');
            $table->unsignedBigInteger('producteur_id'); // Champ pour la clé étrangère
            $table->timestamps();
            // Définition de la relation de clé étrangère
            $table->foreign('producteur_id')->references('id')->on('producteurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelles');
    }
};
