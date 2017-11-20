<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use SoftDeletes;
    protected $table = 'monedas';

    protected $fillable = [
        'codigo', 'nombre', 'id_rubro', 'afecta_codigo_base'
    ];
    protected $dates = ['deleted_at'];

    public function departamentos()
    {
        return $this->hasMany('App\Departamento', 'id_moneda', 'id');
    }
}
