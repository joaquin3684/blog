<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubro extends Model
{
    use SoftDeletes;
    protected $table = 'rubros';

    protected $fillable = [
        'codigo', 'nombre', 'id_capitulo', 'afecta_codigo_base'
    ];
    protected $dates = ['deleted_at'];

    public function monedas()
    {
        return $this->hasMany('App\Moneda', 'id_rubro', 'id');
    }
}
