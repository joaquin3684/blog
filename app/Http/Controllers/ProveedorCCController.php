<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Filtros\VentasFilter;
use App\Ventas;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorCCController extends Controller
{
    public function index()
    {
        return view('proveedor_cc');
    }

    public function cuentaCorrientePorOrganismo(Request $request)
    {

        $usuario = Sentinel::check();

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('proovedores.usuario', $usuario->id)
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('ROUND(SUM(cuotas.importe),2) AS totalACobrar'))
            ->groupBy('organismos.id');

        $organismos = VentasFilter::apply($request->all(), $ventas);

        $movimientos = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->where('proovedores.usuario', $usuario->id)
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('ROUND(SUM(movimientos.entrada),2) AS totalCobrado'));

        $organismos2 = VentasFilter::apply($request->all(), $movimientos);

        $ventasPorOrganismo = $this->unirColecciones($organismos, $organismos2, ["id_organismo"], ['totalCobrado' => 0]);

        $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        return $ventasPorOrganismo->toJson();
    }

    public function cuentaCorrientePorSocio(Request $request)
    {
        $usuario = Sentinel::check();


        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('socios.id')
            ->where('proovedores.usuario', $usuario->id)
            ->where('organismos.id', '=', $request['id'])
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->select('socios.nombre AS socio', 'socios.id AS id_socio',  DB::raw('ROUND(SUM(cuotas.importe),2) AS totalACobrar'));

        $socios = VentasFilter::apply($request->all(), $ventas);


        $movimientos = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->where('proovedores.usuario', $usuario->id)
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('organismos.id', '=', $request['id'])
            ->select('socios.id AS id_socio', DB::raw('ROUND(SUM(movimientos.entrada),2) AS totalCobrado'));

        $socios2 = VentasFilter::apply($request->all(), $movimientos);


        $ventasPorSocio = $this->unirColecciones($socios, $socios2, ["id_socio"], ['totalCobrado' => 0]);

        $ventasPorSocio = $ventasPorSocio->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        return $ventasPorSocio->toJson();
    }

    public function cuentaCorrientePorVentas(Request $request)
    {

        $usuario = Sentinel::check();

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('ventas.id')
            ->where('proovedores.usuario', $usuario->id)
            ->where('socios.id', '=', $request['id'])
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->select('socios.nombre AS socio', 'ventas.id AS id_venta', 'ventas.fecha_vencimiento AS fecha', 'proovedores.razon_social AS proovedor', 'productos.nombre AS producto', 'ventas.nro_cuotas', DB::raw('ROUND(SUM(cuotas.importe),2) AS totalACobrar'));

        $ventas1 = VentasFilter::apply($request->all(), $ventas);

        $movimientos = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('ventas.id')
            ->where('proovedores.usuario', $usuario->id)
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('socios.id', '=', $request['id'])
            ->select('ventas.id AS id_venta', DB::raw('ROUND(SUM(movimientos.entrada),2) AS totalCobrado'));

        $ventas2 = VentasFilter::apply($request->all(), $movimientos);


        $ventasPorVenta = $this->unirColecciones($ventas1, $ventas2, ["id_venta"], ['totalCobrado' => 0]);

        $ventasPorVenta = $ventasPorVenta->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });



        return $ventasPorVenta->toJson();
    }

    public function cuentaCorrientePorCuotas(Request $request)
    {
        $usuario = Sentinel::check();

        $a =  Ventas::with('cuotas.movimientos', 'producto.proovedor')->whereHas('producto.proovedor', function($query) use ($usuario){
            $query->where('usuario', $usuario->id);
        })->find($request['id']);
        $a->cuotas->each(function ($cuota){
            $s = $cuota->movimientos->sum(function($movimiento) {
                return $movimiento->entrada;
            });
            $cuota->cobrado = $s;
        });
        return $a;
    }
}
