<?php   namespace App\Repositories\Eloquent\Repos\Gateway;
use App\Repositories\Eloquent\Cuota;
use App\Repositories\Eloquent\Fechas;
use App\Ventas;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class VentasGateway extends Gateway
{
    function model()
    {
        return 'App\Ventas';
    }


    public function cuotasVencidas($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return $ventas = Ventas::with(['cuotas' => function($query) use ($hoy) {
            $query->where('fecha_inicio', '<', $hoy);
            $query->with('movimientos');
        }])->find($id);
    }

    public function cuotasAPagarProovedor($id_proovedor)
    {
        return $ventas = Ventas::with(['cuotas' => function($query) {
            $query->with(['movimientos' => function($query) {
                $query->where('entrada', '>', 0);
                $query->where('salida', '=', 0);
            }]);
        }, 'producto.proovedor'])->has('cuotas.movimientos')->whereHas('producto.proovedor', function($query) use ($id_proovedor){
            $query->where('id', $id_proovedor);
        })->get();
    }
}