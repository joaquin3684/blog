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
            $q->where('fecha_inicio', '<', $hoy);
            $q->with('movimientos');
        }, 'ventas.producto.proovedor.prioridad'])->find($id);
    }

    public function cuotasFuturas($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return Socios::with(['ventas.cuotas' => function($q) use($hoy){
            $q->where('fecha_inicio', '>', $hoy);
        }, 'ventas.producto.proovedor.prioridad'])->find($id);

    }

    public function cuotasSocialesVencidas($id)
    {
        $hoy = Fechas::getFechaHoy();
        return Socios::with(['cuotasSociales' => function($q) use($hoy){
            $q->where('fecha_inicio', '<', $hoy);
            $q->with('movimientos');
        }])->find($id);
    }
}