<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Ventas extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'id_asociado', 'id_producto', 'descripcion', 'nro_cuotas', 'fecha', 'importe', 'nro_credito', 'fecha_vencimiento'
    ];

    protected $dates = ['deleted_at'];

    public function cuotas()
    {
    	return $this->morphMany(Cuotas::class, 'cuotable');
    }

    public function socio()
    {
    	return $this->belongsTo('App\Socios', 'id_asociado', 'id');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Productos', 'id_producto', 'id');
    }

    public function movimientos()
    {
        return $this->hasManyThrough('App\Movimientos', 'App\Cuotas', 'cuotable_id', 'identificadores_id', 'id');
    }

    public function estados()
    {
        return $this->hasMany('App\EstadoVenta', 'id_venta', 'id');
    }

}
