<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubRubro extends Model
{
    use SoftDeletes;
    protected $table = 'sub_rubros';

    protected $fillable = [
        'codigo', 'nombre', 'id_departamento', 'afecta_codigo_base'
    ];
    protected $dates = ['deleted_at'];

    public function imputaciones()
    {
        return $this->hasMany('App\Imputacion', 'id_subrubro', 'id');
    }
}
