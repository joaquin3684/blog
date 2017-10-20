<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asiento extends Model
{
    use SoftDeletes;
    protected $table = 'asientos';

    protected $fillable = [
        'id_imputacion', 'debe', 'haber', 'fecha_contable'
    ];

    protected $dates = ['deleted_at'];
}
