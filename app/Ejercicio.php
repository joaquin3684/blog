<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ejercicio extends Model
{
    use SoftDeletes;
    protected $table = 'ejercicios';

    protected $fillable = [
        'fecha', 'fecha_cierre'
    ];
    protected $dates = ['deleted_at'];
}
