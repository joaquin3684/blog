<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imputacion extends Model
{
    use SoftDeletes;
    protected $table = 'imputaciones';

    protected $fillable = [
        'codigo', 'nombre', 'id_subrubro'
    ];
    protected $dates = ['deleted_at'];
}
