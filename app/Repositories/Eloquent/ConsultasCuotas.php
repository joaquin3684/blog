<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 19:17
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Fechas as Fechas;
use Illuminate\Support\Facades\DB;

class ConsultasCuotas
{
    private $hoy;

    public function __construct(Fechas $fecha)
    {
        $this->hoy = $fecha->getFechaHoy();
    }

    public function cuotasVencidasDeOrganismos()
    {
        $hoy = $this->hoy;
        $ventas = DB::table('cuotas')
            ->join('ventas', 'ventas.id', '=', 'cuotas.cuotable_id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) AS totalACobrar'))
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })->get();
        return $ventas;
    }
    public function cuotasVencidasDeSociosDelOrganismo($id){
        $hoy = $this->hoy;
        $cuotas = DB::table('cuotas')
            ->join('ventas', 'ventas.id', '=', 'cuotas.cuotable_id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('socios.id')
            ->select('socios.nombre AS socio', 'socios.id AS id_socio', DB::raw('SUM(cuotas.importe) AS totalACobrar'))
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })
            ->where('organismos.id', '=', $id)->get();

        return $cuotas;
    }
    public function cuotasVencidasDelSocio($id)
    {
        $hoy = $this->hoy;
        $cuotas = DB::table('cuotas')
            ->join('ventas', 'ventas.id', '=', 'cuotas.cuotable_id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('prioridades', 'prioridades.id', '=', 'proovedores.id_prioridad')
            ->select('socios.nombre AS socio', 'cuotas.id AS id_cuota', 'cuotas.nro_cuota', 'prioridades.orden', 'socios.id AS id_socio', 'cuotas.importe', 'ventas.id AS id_venta')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('socios.id', '=', $id)->get();
    }
}