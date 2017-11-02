<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlFechaContable extends Model
{
    use SoftDeletes;
    protected $table = 'control_fecha_contables';

    protected $fillable = ['fecha_contable', 'id_usuario'];

    protected $dates = ['deleted_at'];
}
