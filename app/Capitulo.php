<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capitulo extends Model
{
    use SoftDeletes;
    protected $table = 'capitulos';

    protected $fillable = [
        'codigo', 'nombre', 'afecta_codigo_base'
    ];

    protected $dates = ['deleted_at'];

    public function rubros()
    {
        return $this->hasMany('App\Rubro', 'id_capitulo', 'id');
    }
}
