<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'email',
        'password',
        'images',
    ];

    protected $hidden = [
        'password',
    ];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_agent');
    }

    public function producteurs()
    {
        return $this->hasMany(Producteur::class);
    }

    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }

    public function cultures()
    {
        return $this->hasManyThrough(Culture::class, Parcelle::class);
    }
}
