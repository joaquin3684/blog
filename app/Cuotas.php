<?php

namespace App;

use App\Repositories\Eloquent\Fechas;
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

    public function cobrar($monto)
    {
        $cobrado = $this->montoACobrar($monto);
        $this->determinarEstado($cobrado);
        $fecha = Fechas::getFechaHoy();
        $this->movimientos()->create(['identificadores_id' => $this->id, 'identificadores_type' => 'App\Cuotas', 'entrada' => $cobrado, 'fecha' => $fecha]);
        $this->save();
        return $cobrado;
    }

    public function determinarEstado($cobrado)
    {
        $this->estado = $cobrado == $this->importe ? 'Cobro Total' : 'Cobro Parcial';
    }

    public function montoACobrar($monto)
    {
        $montoACobrar = $this->importe - $this->totalCobrado();
        $cobrado = $montoACobrar <= $monto ? $montoACobrar : $monto;
        return $cobrado;
    }

    public function totalCobrado()
    {
        return $this->movimientos()->sum('entrada');
    }

    public function estaImpaga()
    {
        $this->importe != $this->totalCobrado();
    }

    public function pagarProveedor($ganancia)
    {
        return $this->movimientos->sum(function (Movimientos $movimiento) use ($ganancia){
            return $movimiento->pagarProveedor($ganancia);
        });
    }
}
