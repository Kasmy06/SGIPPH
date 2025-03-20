<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_culture',
        'date_culture',
    ];

    public function parcelles()
    {
        return $this->belongsToMany(Parcelle::class, 'contenirs')->withTimestamps();
    }
}
