<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Contabilidad\CalculadorSaldoInicial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MayorContableController extends Controller
{
    public function index()
    {
        return view('mayor_contable');
    }

    public function reporte(Request $request)
    {
        $cuentaDesde = $request['codigo_desde'];
        $cuentaHasta = $request['codigo_hasta'];
        $fechaDesde = $request['fecha_desde'];
        $fechaHasta = $request['fecha_hasta'];

        $saldosInicialesCuentas = CalculadorSaldoInicial::calcular($fechaDesde, $cuentaDesde, $cuentaHasta);


        $asientosCuentas = DB::table('asientos')
            ->where('codigo', '>=', $cuentaDesde)
            ->where('codigo', '<=', $cuentaHasta)
            ->where('fecha_valor', '>=', $fechaDesde)
            ->where('fecha_valor', '<=', $fechaHasta)
            ->orderBy('codigo')
            ->get();

        return $saldosInicialesCuentas->map(function ($saldo) use ($asientosCuentas) {
                    $saldo->asientos = $asientosCuentas->filter(function ($asiento) use ($saldo) {
                        return $saldo->codigo == $asiento->codigo;
                    })->map(function($a) use ($saldo) {
                        $a->saldo = $saldo->saldo + $a->debe - $a->haber;
                        return $a;
                    });
                    return $saldo;
        });


    }
}
