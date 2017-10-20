<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;
    protected $table = 'departamentos';

    protected $fillable = [
        'codigo', 'nombre', 'id_moneda'
    ];
    protected $dates = ['deleted_at'];
}
