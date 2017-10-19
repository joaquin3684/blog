<?php   namespace App\Repositories\Eloquent\Repos\Gateway;
use App\Repositories\Eloquent\Fechas;
use App\Socios;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class SociosGateway extends Gateway
{
    function model()
    {
        return 'App\Socios';
    }

    public function ventasConCuotasVencidas($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return Socios::with(['ventas.cuotas' => function($q) use ($hoy){
            $q->where('fecha_inicio', '<=', $hoy);
            $q->with('movimientos');
        }, 'ventas.producto.proovedor.prioridad'])->find($id);
    }

    public function cuotasFuturas($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return Socios::with(['ventas.cuotas' => function($q) use($hoy){
            $q->where('fecha_inicio', '>', $hoy);
            $q->with('movimientos');
        }, 'ventas.producto.proovedor.prioridad'])->find($id);

    }

    public function cuotasSociales($id)
    {
        return Socios::with('cuotasSociales.movimientos')->find($id);
    }

    public function conTodo($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return Socios::with(['ventas.cuotas.movimientos', 'ventas.producto.proovedor.prioridad'])->find($id);
    }
}