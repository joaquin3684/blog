<?php

namespace App;

use App\Repositories\Eloquent\Cuota;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Ventas extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'id_asociado', 'id_producto', 'descripcion', 'nro_cuotas', 'importe_total', 'nro_credito', 'fecha_vencimiento', 'importe_cuota', 'importe_otorgado', 'id_comercializador'
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
        return $this->hasManyThrough('App\Movimientos', 'App\Cuotas', 'cuotable_id', 'id_cuota', 'id');
    }

    public function estados()
    {
        return $this->hasMany('App\EstadoVenta', 'id_venta', 'id');
    }

    public function tasaMensual()
    {
       return round($this->producto->tasa / $this->nro_cuotas, 2);
    }

    /**
     * @return Cuotas[]
     */
    public function cuotasPendientes()
    {
        return $this->cuotas->filter(function($c){return $c->totalCobrado() !== $c->importe;})->values();
    }
}
