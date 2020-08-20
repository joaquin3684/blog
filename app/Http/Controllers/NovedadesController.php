<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Filtros\VentasFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NovedadesController extends Controller
{

    public function index()
    {
        return view('novedades');
    }

    public function mostrarPorOrganismo(Request $request)
    {

        $ventas = DB::table('ventas')
        ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
        ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
        ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
        ->join('productos', 'productos.id', '=', 'ventas.id_producto')
        ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
        ->where('cuotas.cuotable_type', 'App\Ventas')
        ->where('cuotas.fecha_vencimiento', '>=', $request['fecha_desde'])
        ->where('cuotas.fecha_vencimiento', '<=', $request['fecha_hasta'])
        ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('ROUND(SUM(cuotas.importe), 2) AS totalACobrar'))
        ->groupBy('organismos.id');

        $organismos = VentasFilter::apply($request->all(), $ventas);

        $movimientos = DB::table('ventas')
        ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
        ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
        ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
        ->join('productos', 'productos.id', '=', 'ventas.id_producto')
        ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
        ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
        ->where('cuotas.cuotable_type', 'App\Ventas')
        ->where('cuotas.fecha_vencimiento', '>=', $request['fecha_desde'])
        ->where('cuotas.fecha_vencimiento', '<=', $request['fecha_hasta'])
        ->groupBy('organismos.id')
        ->select('organismos.id AS id_organismo', DB::raw('ROUND(SUM(movimientos.entrada), 2) AS totalCobrado'));

        $organismos2 = VentasFilter::apply($request->all(), $movimientos);

        $ventasPorOrganismo = $this->unirColecciones($organismos, $organismos2, ["id_organismo"], ['totalCobrado' => 0]);
        $col = collect();
        $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key) use ($col){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', round($diferencia,2));
            if($diferencia > 0)
            {
                $col->push($item);
            }
            return $item;
        });

        return $col->toJson();
    }

    public function mostrarPorSocio(Request $request)
    {
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('socios.id')
            ->where('organismos.id', '=', $request['id'])
            ->where('cuotas.fecha_inicio', '>=', $request['fecha_desde'])
            ->where('cuotas.fecha_vencimiento', '<=', $request['fecha_hasta'])
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->select('socios.nombre AS socio', 'socios.legajo', 'socios.id AS id_socio',  DB::raw('ROUND(SUM(cuotas.importe),2) AS totalACobrar'));

        $socios = VentasFilter::apply($request->all(), $ventas);


        $movimientos = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('cuotas.fecha_inicio', '>=', $request['fecha_desde'])
            ->where('cuotas.fecha_vencimiento', '<=', $request['fecha_hasta'])
            ->where('organismos.id', '=', $request['id'])
            ->select('socios.id AS id_socio', DB::raw('ROUND(SUM(movimientos.entrada),2) AS totalCobrado'));

        $socios2 = VentasFilter::apply($request->all(), $movimientos);


        $ventasPorSocio = $this->unirColecciones($socios, $socios2, ["id_socio"], ['totalCobrado' => 0]);
        $col = collect();
        $ventasPorSocio = $ventasPorSocio->each(function ($item, $key) use ($col){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', round($diferencia,2));
            if($diferencia > 0)
            {
                $nombre = explode(',', $item['socio']);
                $item->put('nombre', $nombre[0]);
                $item->put('apellido', $nombre[1]);
                $col->push($item);

            }
            return $item;
        });

        return $col->toJson();

    }

}
