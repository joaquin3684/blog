<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Filtros\VentasFilter;
use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Repositories\Eloquent\Ventas;
use Illuminate\Http\Request;
use App\Movimientos;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;

class PagoProovedoresController extends Controller
{
   public function index()
    {
        return view('pago_proovedores');
    }

    public function datos(Request $request)
    {


        $proovedores = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->select('proovedores.razon_social AS proovedor', 'cuotas.nro_cuota', 'cuotas.importe', 'socios.nombre', 'socios.apellido', 'socios.legajo', 'cuotas.estado', 'proovedores.id AS id_proovedor', DB::raw('SUM(movimientos.entrada) AS totalCobrado'), DB::raw('SUM(movimientos.salida) AS totalPagado'), DB::raw('((SUM(movimientos.entrada) - SUM(movimientos.salida) ) * productos.ganancia / 100) AS diferencia'))
            ->groupBy('productos.id', 'proovedores.id')

            ->havingRaw('totalCobrado <> totalPagado')->get();

        $proovedores->map(function($proveedor){
           //todo hay que terminar esto para que pueda armarme una coleccion unica aplanada por cada id_proveedor y sumarizar la ganancia y el total cobrado y la diferencia
            //
        });

        return $proovedores;

        $organismos2 = VentasFilter::apply($request->all(), $movimientos);


        $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $proovedores = Proovedores::with(['productos' => function($q) {
            $q->has('ventas');
            $q->has('ventas.movimientos');
            $q->with(['ventas' => function($q){
                $q->has('movimientos');
                $q->with(['cuotas' => function($q) {
                    $q->whereHas('movimientos', function($q){
                        $q->where('salida', null);
                        $q->where('entrada', '>', 0);
                    });
                }]);
                $q->with('socio');
                $q->with(['movimientos' => function($q){
                    $q->where('salida', null);
                    $q->where('entrada', '>', 0);
                }]);
            }]);
        }])->has('productos.ventas.movimientos')->get();


        $proovedores->each(function($proovedor) {

            $totalAPagar = $proovedor->productos->sum(function ($producto) {
                $porcentaje = $producto->ganancia;
                return $producto->ventas->sum(function ($venta) use ($porcentaje) {

                    $total = $venta->movimientos->sum(function ($movimiento) {
                        return $movimiento->entrada;
                    });
                    return $pagar = $total - $total * $porcentaje / 100;
                });
            });
            $proovedor->total = $totalAPagar;

        });
        return $proovedores->toJson();
    }

    public function detalleProveedor(Request $request){

    }

    public function traerDatosAutocomplete(Request $request)
    {
        $movimientos = DB::table('cuotas')
            ->join('movimientos', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', function($join){
                $join->on('movimientos.id_asociado', '=', 'socios.id')->groupBy('socios.id');

            })
            ->join('productos', function($join){
                $join->on('movimientos.id_producto', '=', 'productos.id')->groupBy('productos.id');
            })
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->whereExists(function ($query) use ($request){
                $this->filtros($request,$query);
               
            })
            ->where('cuotas.cobro', '=', '1')
            ->where('cuotas.pago', '=', '0')
            ->select('movimientos.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $movimientos->unique($request['groupBy']);
            if(sizeof($movimientos) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['movimientos' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
            }
    }

    public function pagarCuotas(Request $request)
    {
        foreach($request->all() as $proveedor)
        {
            $ventasRepo = new VentasRepo();
            $ventas = $ventasRepo->cuotasAPagarProovedor($proveedor['id']);
            $ventas->each(function ($venta) {
                $venta->pagarProovedor();
            });
        }
    }


}
