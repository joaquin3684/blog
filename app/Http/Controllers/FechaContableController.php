<?php

namespace App\Http\Controllers;

use App\ControlFechaContable;
use App\Ejercicio;
use App\Exceptions\FechaContableElejidaEnEjercicioCerradoException;
use App\Exceptions\LaFechaContablaYaEstaCerradaException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FechaContableController extends Controller
{
    public function setearFechaContable(Request $request)
    {
        DB::transaction(function() use ($request) {
            $ejercicios = Ejercicio::where('fecha_cierre', null)->where('fecha', '<', $request['fecha'])->get();

            if($ejercicios->isEmpty())
            {
                throw new FechaContableElejidaEnEjercicioCerradoException('fecha_contable_ejercicio_cerrado');
            }
            else
            {
                $user = Sentinel::check();
                $fecha = ControlFechaContable::where('id_usuario', $user->id)->first();
                if($fecha == null)
                {
                    ControlFechaContable::create(['fecha_contable' => $request['fecha'], 'id_usuario' => $user->id]);

                } else {
                    $fecha->fecha_contable = $request['fecha'];
                    $fecha->save();
                }
            }
        });
    }

    public function cerrarFechaContable()
    {
        DB::transaction(function() {

            $user = Sentinel::check();
            $fecha = ControlFechaContable::where('id_usuario', $user->id)->first();
            if($fecha == null)
            {
                throw new LaFechaContablaYaEstaCerradaException('fecha_contable_cerrada');
            }
            else
            {
                ControlFechaContable::where('id_usuario', $user->id)->delete();
            }

        });
    }
}
