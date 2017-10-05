<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use SoftDeletes;
    protected $table = 'monedas';

    protected $fillable = [
        'codigo', 'nombre', 'id_rubro'
    ];
}
