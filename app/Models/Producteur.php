<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
    use HasFactory;

    protected $table = 'producteurs'; // Nom de la table

    protected $fillable = [
        'nom',
        'prenom',
        'genre',
        'contact',
        'localite',
        'naissance',
        'images',
        'id_agent',
    ];

    protected $casts = [
        'naissance' => 'date',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'id_agent');
    }

    /**
     * Accesseur pour récupérer l'URL complète de l'image si stockée.
     */
    public function getImageUrlAttribute()
    {
        return $this->images ? asset('storage/' . $this->images) : null;
    }

    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }
}
