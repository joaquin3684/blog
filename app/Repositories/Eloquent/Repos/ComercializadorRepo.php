<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 19:05
 */

namespace App\Repositories\Eloquent\Repos;


use App\Comercializador;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Mapper\ComercializadorMapper;
use App\Solicitud;

class ComercializadorRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new ComercializadorGateway();
        $this->mapper = new ComercializadorMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\ComercializadorRepo';
    }

    public function solicitudesPendientesDeCobro($id)
    {
        return Solicitud::with('socio', 'producto.porcentajes')->where('comercializador', $id)->where('estado', 'Solicitud Aprobada')->get();
    }

    public function comercializadoresConSolicitudesTerminadas()
    {
        return Comercializador::whereHas('solicitudes', function($query){
            $query->where('estado', 'Pagada')
                ->orWhere('estado', 'Rechazada por comercializador')
                ->orWhere('estado', 'Solicitud Aprobada')
                ->orWhere('estado', 'Rechazada por Inversionista');
        })->get();
    }

    public function solicitudesTerminadasComer($id)
    {
        return Solicitud::with('socio' )
        ->where('comercializador', $id)->where('estado', 'Pagada')->orWhere(function($query){
            $query->where('estado', 'Pagada')
                ->orWhere('estado', 'Rechazada por comercializador')
                ->orWhere('estado', 'Solicitud Aprobada')
                ->orWhere('estado', 'Rechazada por Inversionista');
            })->get();
    }

    public function comercializadoresConSolicitudesAprobadas()
    {
        return Comercializador::whereHas('solicitudes', function($query){
            $query->where('estado', 'Solicitud Aprobada');
        })->get();
    }


}