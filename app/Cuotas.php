<?php

namespace App;

use App\Repositories\Eloquent\Fechas;
use Carbon\Carbon;
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
    	return $this->hasMany(Movimientos::class, 'id_cuota');
    }

     public function venta()
    {
    	return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }

    public function cuotable()
    {
        return $this->morphTo();
    }

    public function totalCobrado()
    {
        return $this->movimientos()->sum('entrada');
    }

    public function cobrar($monto)
    {
        $montoRestante = $this->importe - $this->totalCobrado();
        $cobrado = $montoRestante <= $monto ? $montoRestante : $monto;
        $this->estado = $cobrado == $this->importe ? 'Cobro Total' : 'Cobro Parcial';
        $this->save();
        Movimientos::create([
            'id_cuota' => $this->id,
            'entrada' => $cobrado,
            'salida' => 0,
            'fecha' => Carbon::today()->toDateString(),
            'ganancia' => 0,
            'contabilizado_entrada' => 0,
            'contabilizado_salida' => 0
        ]);

        return $cobrado;
    }


}
