<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Mapper\CuotasMapper;
use App\Repositories\Eloquent\Mapper\SociosMapper;
use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Socio;
use Illuminate\Http\Request;
use App\Ventas;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;
use Carbon\Carbon;
use App\Prioridades;
use App\Movimientos;
use Debugbar;
use App\Repositories\Eloquent\ConsultasCuotas;
use App\Repositories\Eloquent\ConsultasMovimientos;
use App\Repositories\Eloquent\Filtros;
use App\Repositories\Eloquent\Tabla;
use App\Repositories\Eloquent\Ventas as RepoVentas;
use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;
use App\Repositories\Eloquent\Repos\VentasRepo;

class CobrarController extends Controller
{
    private $cuotas;
    private $movimientos;
    private $filtros;
    private $tabla;
    private $cobrar;

    public function __construct(ConsultasCuotas $cuotas, Tabla $tabla, ConsultasMovimientos $movimientos, Filtros $filtros)
    {
        $this->cuotas = $cuotas;
        $this->movimientos = $movimientos;
        $this->filtros = $filtros;
        $this->tabla = $tabla;

    }

    public function index()
    {
        
        return view('cobrar');

    }
    public function datos(Request $request)
    {

        $cuotas = $this->cuotas->cuotasVencidasDeOrganismos();
        $movimientos = $this->movimientos->movimientosHastaHoyDeOrganismos();
        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_organismo'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);

    }
    public function mostrarPorSocio(Request $request)
    {
        $cuotas = $this->cuotas->cuotasVencidasDeSociosDelOrganismo($request['id']);
        $movimientos = $this->movimientos->movimientosHastaHoyDeSociosDelOrganismo($request['id']);
        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_socio'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
           return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);
    }
    public function mostrarPorVenta(Request $request)
    {
        $hoy = Carbon::today()->toDateString();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('ventas.id')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('socios.id', '=', $request['id'])
            ->select('socios.nombre AS socio', 'ventas.id AS id_venta', 'proovedores.nombre AS proovedor', DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->groupBy('ventas.id')
            ->where('socios.id', '=', $request['id'])
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->select('ventas.id AS id_venta', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        $cobrado = $this->unirColecciones($ventas, $movimientos, ["id_venta"], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);


    }

    public function cobrarPorPrioridad(Request $request)
    {
        foreach($request->all() as $socio)
        {
            $socioRepo = new SociosRepo();
            $socio = $socioRepo->ventasConCuotasVencidas($socio['id']);
            $cobrar = new CobrarPorSocio($socio);
            $cobrar->cobrar($socio['monto']);
        }

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
            ->where('cuotas.cobro', '=', '0')
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

    public function cobrarPorVenta(Request $request)
    {
        foreach($request->all() as $venta)
        {
            $ventasRepo = new VentasRepo();
            $ventaCuotasVencidas = $ventasRepo->cuotasVencidas($venta['id_venta']);

            $cobrar = new CobrarPorVenta();
            $cobrar->cobrar($ventaCuotasVencidas, $venta['cobro']);
        }
    }

}
