<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Filtros\CC_CuotasSocialesFilter;
use App\Socios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CC_CuotasSocialesController extends Controller
{
    public function index()
    {
        return view('cc_cuotasSociales');
    }

    public function mostrarPorOrganismos(Request $request)
    {
        $ventas = DB::table('socios')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) AS totalACobrar'))
            ->groupBy('organismos.id');

        $organismos = CC_CuotasSocialesFilter::apply($request, $ventas);

        $movimientos = DB::table('socios')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('SUM(movimientos.entrada) AS totalCobrado'));

        $organismos2 = CC_CuotasSocialesFilter::apply($request, $movimientos);

        $ventasPorOrganismo = $this->unirColecciones($organismos, $organismos2, ["id_organismo"], ['totalCobrado' => 0]);

        $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        return $ventasPorOrganismo->toJson();
    }

    public function mostrarPorSocios(Request $request)
    {
        $ventas = DB::table('socios')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('socios.id')
            ->where('organismos.id', '=', $request['id'])
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->select('socios.nombre AS socio', 'socios.id AS id_socio',  DB::raw('SUM(cuotas.importe) AS totalACobrar'));

        $socios = CC_CuotasSocialesFilter::apply($request, $ventas);


        $movimientos = DB::table('socios')
            ->join('cuotas', 'cuotas.cuotable_id', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->where('organismos.id', '=', $request['id'])
            ->select('socios.id AS id_socio', DB::raw('SUM(movimientos.entrada) AS totalCobrado'));

        $socios2 = CC_CuotasSocialesFilter::apply($request, $movimientos);


        $ventasPorSocio = $this->unirColecciones($socios, $socios2, ["id_socio"], ['totalCobrado' => 0]);

        $ventasPorSocio = $ventasPorSocio->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        return $ventasPorSocio->toJson();
    }

    public function mostrarPorCuotas(Request $request)
    {
        $a =  Socios::with('cuotasSociales.movimientos')->find($request['id']);
        $a->cuotasSociales->each(function ($cuota){
            $s = $cuota->movimientos->sum(function($movimiento) {
                return $movimiento->entrada;
            });
            $cuota->cobrado = $s;
        });
        return $a;

    }

}
