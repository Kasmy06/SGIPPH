<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'genre',
        'email',
        'contact',
        'password',
        'images'
    ];

    // Hashage automatique du mot de passe
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'admin_agent');
    }
}
