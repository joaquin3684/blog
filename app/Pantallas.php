<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pantallas extends Model
{
    
    protected $table = 'pantallas';

    protected $fillable = [
        'nombre'
    ];

    protected $dates = ['deleted_at'];
}
