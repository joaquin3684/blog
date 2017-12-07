<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Filtros\VentasFilter;
use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Repositories\Eloquent\Ventas;
use Illuminate\Http\Request;
use App\Movimientos;
use App\Cuotas;
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
            ->select('proovedores.razon_social AS proovedor', 'cuotas.nro_cuota', 'cuotas.importe', 'socios.nombre', 'socios.legajo', 'cuotas.estado', 'proovedores.id AS id_proovedor', DB::raw('SUM(movimientos.entrada) AS totalCobrado'), DB::raw('SUM(movimientos.salida) AS totalPagado'), DB::raw('(( SUM(movimientos.entrada) - SUM(movimientos.salida) ) * productos.ganancia / 100) AS comision'))
            ->groupBy('proovedores.id', 'productos.id')
            ->havingRaw('totalCobrado <> totalPagado')->get();

        $proov = $proovedores->unique('id_proovedor');
        $pnuevo = $proov->each(function($p) use($proovedores){
            $totalCobrado = 0;
            $totalPagado = 0;
            $comision = 0;
            $totalAPagar =0;
            foreach($proovedores as $pro){
                if($pro->id_proovedor == $p->id_proovedor)
                {
                    $totalCobrado += $pro->totalCobrado;
                    $totalPagado += $pro->totalPagado;
                    $comision += $pro->comision;
                    $totalAPagar = ($totalCobrado - $totalPagado) - $comision;
                }
            }
            $p->totalCobrado = $totalCobrado;
            $p->totalPagado = $totalPagado;
            $p->comision = $comision;
            $p->totalAPagar = $totalAPagar;
        });

        $pnuevo = $pnuevo->unique('id_proovedor');
        return $pnuevo;

    }

    public function detalleProveedor(Request $request)
    {

        $proovedores = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->where('proovedores.id', $request['id'])
            ->select('cuotas.nro_cuota', 'cuotas.importe', 'ventas.id as servicio', 'socios.nombre', 'cuotas.fecha_vencimiento', 'socios.legajo', 'cuotas.estado', DB::raw('SUM(movimientos.entrada) AS totalCobrado'), DB::raw('SUM(movimientos.salida) AS totalPagado'), DB::raw('(SUM(movimientos.salida) * productos.ganancia / 100) AS comision'))
            ->groupBy('cuotas.id')
            ->havingRaw('totalCobrado <> totalPagado')->get();

        return $proovedores;
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
