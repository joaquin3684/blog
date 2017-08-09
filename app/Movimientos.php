<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
   	use SoftDeletes;

	protected $fillable = [
        'identificadores_id', 'identificadores_type', 'entrada', 'salida', 'fecha', 'nro_cuota', 'gastos_administrativos', 'ganancia'
    ];

    protected $dates = ['deleted_at'];

    public function identificadores()
    {
    	return $this->morphTo();
    }
}
