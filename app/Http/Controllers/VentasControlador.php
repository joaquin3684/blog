<?php

namespace App\Http\Controllers;

use App\EstadoVenta;
use App\Repositories\Eloquent\Filtros\OrganismoFilter;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Services\VentasService;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Ventas;
use App\Cuotas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Organismos;
use App\Repositories\Eloquent\Ventas as RepoVentas;
use App\Repositories\Eloquent\Filtros\VentasFilter;
class VentasControlador extends Controller
{

    private $service;
    public function __construct(){
        $this->service = new VentasService();
    }

    public function index()
    {
        return view('CuentasCorrientes');
    }

    public function mostrarPorVenta(Request $request)
    {

        $var = "'App\\".'\\'."Ventas'";

        return DB::select(DB::raw("SELECT socios.nombre AS socio, ventas.id AS id_venta, ventas.fecha_vencimiento AS fecha, proovedores.razon_social AS proovedor, productos.nombre AS producto, ventas.nro_cuotas, ROUND(SUM(cuotas.importe),2) AS totalACobrar, IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS totalCobrado, ROUND(IFNULL((ROUND(SUM(cuotas.importe),2) - ROUND(SUM(movimientos.entrada),2)), 0), 2) AS diferencia 
                            FROM (ventas
                            INNER JOIN cuotas ON cuotas.cuotable_id = ventas.id)
                            LEFT JOIN movimientos ON movimientos.identificadores_id = cuotas.id
                            INNER JOIN socios ON socios.id = ventas.id_asociado
                            INNER JOIN productos ON productos.id = ventas.id_producto
                            INNER JOIN proovedores ON proovedores.id = productos.id_proovedor
                            WHERE cuotas.cuotable_type = $var AND socios.id = ".$request['id']."
                            GROUP BY ventas.id"));

    }

    public function mostrarMovimientosVenta(Request $request)
    {
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
            ->join('movimientos', 'movimientos.identificadores_id', 'cuotas.id')
            ->where('ventas.id', '=', $request['id'])
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->where('cuotas.cuotable_type', 'App\Ventas')
            ->select('movimientos.*', 'cuotas.nro_cuota');

        $ventas1 = VentasFilter::apply($request->all(), $ventas);

        return $ventas1->toJson();
    }

    public function mostrarPorCuotas(Request $request)
    {
        $a =  Ventas::with('cuotas.movimientos', 'producto.proovedor')->find($request['id']);
                $a->cuotas->each(function ($cuota){
                    $s = $cuota->movimientos->sum(function($movimiento) {
                        return $movimiento->entrada;
                    });
                    $cuota->cobrado = $s;
                });
        return $a;



    }

    public function store(Request $request)
    {
        DB::transaction(function() use ($request)
        {

            $this->service->crearVenta($request->all());
        });
    }

    public function mostrarPorSocio(Request $request)
    {
        $var = "'App\\".'\\'."Ventas'";

        return DB::select(DB::raw("SELECT socios.nombre AS socio, socios.id AS id_socio, socios.legajo, ROUND(SUM(cuotas.importe),2) AS totalACobrar, IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS totalCobrado, ROUND(IFNULL((ROUND(SUM(cuotas.importe),2) - ROUND(SUM(movimientos.entrada),2)), 0), 2) AS diferencia 
                            FROM (ventas
                            INNER JOIN cuotas ON cuotas.cuotable_id = ventas.id)
                            LEFT JOIN movimientos ON movimientos.identificadores_id = cuotas.id
                            INNER JOIN socios ON socios.id = ventas.id_asociado
                            INNER JOIN organismos ON organismos.id = socios.id_organismo
                            WHERE cuotas.cuotable_type = $var AND organismos.id = ".$request['id']."
                            GROUP BY socios.id, socios.nombre, socios.legajo"));

    }

    public function mostrarPorOrganismo(Request $request)

    {
        $var = "'App\\".'\\'."Ventas'";

        return DB::select(DB::raw("SELECT organismos.nombre AS organismo, organismos.id AS id_organismo, ROUND(SUM(cuotas.importe),2) AS totalACobrar, IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS totalCobrado, ROUND(IFNULL((ROUND(SUM(cuotas.importe),2) - ROUND(SUM(movimientos.entrada),2)), 0), 2) AS diferencia 
                            FROM (ventas
                            INNER JOIN cuotas ON cuotas.cuotable_id = ventas.id)
                            LEFT JOIN movimientos ON movimientos.identificadores_id = cuotas.id
                            INNER JOIN socios ON socios.id = ventas.id_asociado
                            INNER JOIN organismos ON organismos.id = socios.id_organismo
                            WHERE cuotas.cuotable_type = $var
                            GROUP BY organismos.id, organismos.nombre"));

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
                $this->filtrosQueryBuilder($request,$query);
               
            })
            ->select('ventas.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $ventas->unique($request['groupBy']);
            if(sizeof($ventas) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['ventas' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
            }
    }

    public function cancelarVenta(Request $request)
    {
        DB::transaction(function() use ($request) {
            $ventaRepo = new VentasRepo();
            $elem = $request->all();
            $id = $elem['id_venta'];
            $motivo = $elem['motivo'];
            $venta = $ventaRepo->findWithCuotas($id);
            $venta->cancelar($motivo);
        });
    }
}
