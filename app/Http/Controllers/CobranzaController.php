<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ventas;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;
use Carbon\Carbon;

class CobranzaController extends Controller
{
    public function index()
    {
        return view('cobranza');
    }

    public function datos(Request $request)
    {
        $fechaHoy = Carbon::today();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) - SUM(cuotas.cobro) AS importe'))
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<', $fechaHoy);
                        });
            })
            ->whereColumn('cuotas.cobro', '<', 'cuotas.importe');
            
     	return  $tabla =  Datatables::of($ventas)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);
    }

    public function mostrarPorSocio(Request $request)
    {
                $fechaHoy = Carbon::today();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('socios.id')
            ->select('socios.nombre AS socio', 'socios.id AS id_asociado', DB::raw('SUM(cuotas.importe) - SUM(cuotas.cobro) AS deuda'))
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<', $fechaHoy);
                        });
            })
            ->whereColumn('cuotas.cobro', '<', 'cuotas.importe')
            ->where('organismos.id', '=', $request['id']);
            
        return  $tabla =  Datatables::of($ventas)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);
    }


    public function traerDatosAutocomplete(Request $request)
    {
        $ventas = DB::table('cuotas')
            ->join('ventas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', function($join){
                $join->on('ventas.id_asociado', '=', 'socios.id')->groupBy('socios.id');

            })
            ->join('productos', function($join){
                $join->on('ventas.id_producto', '=', 'productos.id')->groupBy('productos.id');
            })
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->whereExists(function ($query) use ($request){
                $this->filtros($request,$query);
               
            })
            ->where('cuotas.pago', '=', '0')
            ->select('ventas.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $ventas->unique($request['groupBy']);
            if(sizeof($ventas) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['ventas' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
            }
    }


}
