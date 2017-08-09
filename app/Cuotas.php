<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Cuotas extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'cuotable_id', 'cuotable_type', 'importe', 'estado', 'nro_cuota', 'fecha_vencimiento', 'fecha_inicio'
    ];

    protected $dates = ['deleted_at'];

    public function movimientos()
    {
    	return $this->morphMany(Movimientos::class, 'identificadores');
    }

     public function venta()
    {
    	return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }

    public function cuotable()
    {
        return $this->morphTo();
    }

}
