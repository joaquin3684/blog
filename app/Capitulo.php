<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capitulo extends Model
{
    use SoftDeletes;
    protected $table = 'capitulos';

    protected $fillable = [
        'codigo', 'nombre'
    ];
}
