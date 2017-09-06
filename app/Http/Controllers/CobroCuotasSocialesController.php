<?php

namespace App\Http\Controllers;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Repositories\Eloquent\Cobranza\CobrarCuotasSociales;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroCuotasSocialesController extends Controller
{
    public function index()
    {
        return view('cobro_cuotas_sociales');
    }

    public function mostrarPorOrganismo(Request $request)
    {
        $hoy = Carbon::today()->toDateString();
        $cuotas = DB::table('cuotas')
            ->join('socios', 'socios.id', '=', 'cuotas.cuotable_id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) AS totalACobrar'))
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })->get();

        $movimientos = DB::table('cuotas')
            ->join('socios', 'socios.id', '=', 'cuotas.cuotable_id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))
            ->get();

        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_organismo'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $cobrado;
    }

    public function mostrarPorSocio(Request $request)
    {
        $id = $request['id'];
        $hoy = Carbon::today()->toDateString();
        $cuotas = DB::table('cuotas')
            ->join('socios', 'socios.id', '=', 'cuotas.cuotable_id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('socios.id')
            ->select('socios.nombre AS socio', 'socios.id AS id_socio', 'socios.legajo', DB::raw('SUM(cuotas.importe) AS totalACobrar'))
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })
            ->where('organismos.id', '=', $id)->get();


        $movimientos = DB::table('cuotas')
            ->join('socios', 'socios.id', '=', 'cuotas.cuotable_id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->where('organismos.id', '=', $id)
            ->where('cuotas.cuotable_type', 'App\Socios')
            ->where('movimientos.identificadores_type', 'App\Cuotas')
            ->select('socios.id AS id_socio', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))
            ->get();
        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_socio'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $cobrado;
    }

    public function cobrar(Request $request)
    {
        $errores = collect();
        foreach ($request->all() as $elem)
        {
            $id_socio = $elem['id'];
            $monto = $elem['monto'];
            $socioRepo = new SociosRepo();
            $socio = $socioRepo->cuotasSociales($id_socio);
            $cobrarObj = new CobrarCuotasSociales();
            try{
                $cobrarObj->cobrar($socio, $monto);
            } catch (MasPlataCobradaQueElTotalException $e)
            {
                $errores->push($e->toArray());
            }
        }
        return $errores;
    }
}
