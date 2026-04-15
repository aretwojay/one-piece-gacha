<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'nom', 
        'titre', 
        'origine', 
        'capacites', 
        'avancement', 
        'prime', 
        'image_url'
    ];

    protected $casts = [
        'capacites' => 'array',
    ];
}