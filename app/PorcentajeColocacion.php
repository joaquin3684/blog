<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PorcentajeColocacion extends Model
{
    protected $table = 'porcentaje_colocaciones';

    protected $fillable = [ 'desde', 'hasta', 'porcentaje', 'id_producto'];

}
