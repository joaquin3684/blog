<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asiento extends Model
{
    protected $table = 'asientos';

    protected $fillable = [
        'id_imputacion', 'nombre', 'debe', 'haber', 'fecha_contable', 'nro_asiento', 'id_ejercicio', 'fecha_valor', 'codigo'
    ];

    protected $dates = ['deleted_at'];
}
