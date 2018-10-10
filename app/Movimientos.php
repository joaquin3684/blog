<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
   	use SoftDeletes;

	protected $fillable = [
        'identificadores_id', 'identificadores_type', 'entrada', 'salida', 'fecha', 'ganancia', 'contabilizado_entrada', 'contabilizado_salida'
    ];

    protected $dates = ['deleted_at'];

    public function identificadores()
    {
    	return $this->morphTo();
    }

    public function pagarProveedor($ganancia)
    {
        $this->salida = $this->entrada;
        $this->ganancia = round($this->entrada * $ganancia /100, 2);
        $this->save();
        return $this->entrada - $this->ganancia;
    }
}
