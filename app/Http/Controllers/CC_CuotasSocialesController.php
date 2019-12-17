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

        $var = "'App\\".'\\'."Socios'";

        return DB::select(DB::raw("SELECT organismos.nombre AS organismo, organismos.id AS id_organismo, ROUND(SUM(cuotas.importe),2) AS totalACobrar, IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS totalCobrado, ROUND(IFNULL((ROUND(SUM(cuotas.importe),2) - ROUND(SUM(movimientos.entrada),2)), 0), 2) AS diferencia 
                            FROM (socios
                            INNER JOIN cuotas ON cuotas.cuotable_id = socios.id)
                            LEFT JOIN movimientos ON movimientos.id_cuota = cuotas.id
                            INNER JOIN organismos ON organismos.id = socios.id_organismo
                            WHERE cuotas.cuotable_type = $var
                            GROUP BY organismos.id, organismos.nombre"));

    }

    public function mostrarPorSocios(Request $request)
    {
        $var = "'App\\".'\\'."Socios'";

        return DB::select(DB::raw("SELECT socios.legajo as legajo, socios.nombre AS socio, socios.id AS id_socio, ROUND(SUM(cuotas.importe),2) AS totalACobrar, IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS totalCobrado, ROUND(IFNULL((ROUND(SUM(cuotas.importe),2) - ROUND(SUM(movimientos.entrada),2)), 0), 2) AS diferencia 
                            FROM (socios
                            INNER JOIN cuotas ON cuotas.cuotable_id = socios.id)
                            LEFT JOIN movimientos ON movimientos.id_cuota = cuotas.id
                            INNER JOIN organismos ON organismos.id = socios.id_organismo
                            WHERE organismos.id = ".$request['id']." AND cuotas.cuotable_type = $var
                            GROUP BY socios.id, socios.nombre"));

    }

    public function mostrarPorCuotas(Request $request)
    {
        $var = "'App\\".'\\'."Socios'";

        return DB::select(DB::raw("SELECT cuotas.* , IFNULL(ROUND(SUM(movimientos.entrada),2),0) AS cobrado 
                            FROM (socios
                            INNER JOIN cuotas ON cuotas.cuotable_id = socios.id)
                            LEFT JOIN movimientos ON movimientos.id_cuota = cuotas.id
                            INNER JOIN organismos ON organismos.id = socios.id_organismo
                            WHERE socios.id = ".$request['id']." AND cuotas.cuotable_type = $var"));


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
