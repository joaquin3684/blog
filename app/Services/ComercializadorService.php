<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/10/18
 * Time: 12:59
 */

namespace App\Services;


use App\Comercializador;
use App\Repositories\Eloquent\FileManager;
use App\Socios;
use App\Solicitud;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class ComercializadorService
{
    public function generarSolicitud($solicitud)
    {
        $solicitud = collect($solicitud);
        $usuario = Sentinel::check();
        $comercializador = Comercializador::where('usuario', $usuario->id)->first();

        if(!$solicitud->has('id_socio'))
        {
            $socio = Socios::create($solicitud->toArray());
            $solicitud->put('id_socio', $socio->id);
            $socio->delete();
        }

        $solicitud->put('estado', 'Procesando Solicitud');
        $solicitud->put('comercializador', $comercializador->id);

       return Solicitud::create($solicitud->toArray());



    }
}