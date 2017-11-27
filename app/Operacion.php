<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operacion extends Model
{
    use SoftDeletes;
    protected $table = 'operaciones';
    protected $fillable = [
        'nombre', 'entrada', 'salida'
    ];

    protected $dates = ['deleted_at'];

    public function imputaciones()
    {
        return $this->belongsToMany('App\Imputacion', 'operacion_imputacion', 'id_operacion', 'id_imputacion')
            ->withPivot('debe', 'haber');
    }
}
