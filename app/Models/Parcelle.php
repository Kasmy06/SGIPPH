<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcelle extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'superficie', 'latitude', 'longitude', 'producteur_id']; // Champs autorisés

    // Relation avec le modèle Producteur
    public function producteur()
    {
        return $this->belongsTo(Producteur::class);
    }

    public function cultures()
{
    return $this->belongsToMany(Culture::class, 'contenirs')->withTimestamps();
}

}
