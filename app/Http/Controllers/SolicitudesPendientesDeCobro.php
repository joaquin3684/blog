<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesPendientesDeCobro extends Controller
{

    private $repo;
    public function __construct(ComercializadorRepo $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        return view('solicitudesPendientesDeCobro');
    }

    public function solicitudes()
    {

        $usuario = Sentinel::check();
        $comer = $this->repo->findByUser($usuario->id);

        $solicitudes = $this->repo->solicitudesPendientesDeCobro($comer->getId());

        $productos = array();

        $solicitudes->each(function($solicitud) use (&$productos){
            $index = $this->getIndex($solicitud->id_producto, $productos);
            if($index != -1)
           {
                $productos[$index]['total'] += $solicitud->total;
           } else {
                $producto = array('id' => $solicitud->id_producto, 'total' => $solicitud->total, 'porcentajes' => $solicitud->producto->porcentajes->toArray());
                array_push($productos, $producto);
           }
        });

        foreach($productos as &$producto) {
            $producto['porcentajeElejido'] = $producto['porcentajes'][count($producto['porcentajes']) - 1]['porcentaje'];
            foreach ($producto['porcentajes'] as $porcentaje)
            {
                if ($producto['total'] < $porcentaje['hasta'] && $producto['total'] > $porcentaje['desde'])
                {
                    $producto['porcentajeElejido'] = $porcentaje['porcentaje'];
                }
            }
        }

        $solicitudes->each(function($solicitud) use ($productos, $comer){
           $index = $this->getIndex($solicitud->id_producto, $productos);
           $montoComer = ($solicitud->monto_pagado * $productos[$index]['porcentajeElejido'] /100) * $comer->getPorcentajeColocacion() /100;
           $solicitud['montoACobrar'] = round($montoComer,2);
        });

        return $solicitudes;
    }

    public function getIndex($id, $array)
    {

        foreach($array as $key => $value)
        {
            if ($value['id'] == $id)
            {
                return $key;
            }
        }
        return -1;
    }
}
