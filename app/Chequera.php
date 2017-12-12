<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chequera extends Model
{
    use SoftDeletes;
    protected $table = 'chequeras';

    protected $fillable = [
        'nro_chequera', 'nro_inicio', 'nro_fin', 'estado', 'id_banco'
    ];

    protected $dates = ['deleted_at'];
}
