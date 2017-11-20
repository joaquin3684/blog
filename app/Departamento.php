<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;
    protected $table = 'departamentos';

    protected $fillable = [
        'codigo', 'nombre', 'id_moneda', 'afecta_codigo_base'
    ];
    protected $dates = ['deleted_at'];

    public function subRubros()
    {
        return $this->hasMany('App\SubRubro', 'id_departamento', 'id');
    }
}
