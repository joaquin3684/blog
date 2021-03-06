<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use App\Repositories\Eloquent\Repos\SolicitudRepo;
use App\Services\AsientoService;
use Illuminate\Http\Request;

class PagoSolicitudesPendientesDeCobro extends Controller
{

    private $repo;
    private $solRepo;
    public function __construct(ComercializadorRepo $repo, SolicitudRepo $solRepo)
    {
        $this->repo = $repo;
        $this->solRepo = $solRepo;
    }

    public function index()
    {
        return view('pagoSolicitudesPendientesDeCobro');
    }

    public function pagar(Request $request)
    {
        foreach($request['comercializadores'] as $comer) {

            $comer = $this->repo->find($comer['id']);
            $solicitudes = $this->repo->solicitudesPendientesDeCobro($comer->getId());

            $productos = array();

            $solicitudes->each(function ($solicitud) use (&$productos) {
                $index = $this->getIndex($solicitud->id_producto, $productos);
                if ($index != -1) {
                    $productos[$index]['total'] += $solicitud->total;
                } else {
                    $producto = array('id' => $solicitud->id_producto, 'total' => $solicitud->total, 'porcentajes' => $solicitud->producto->porcentajes->toArray());
                    array_push($productos, $producto);
                }
            });

            foreach ($productos as &$producto) {
                $producto['porcentajeElejido'] = $producto['porcentajes'][count($producto['porcentajes']) - 1]['porcentaje'];
                foreach ($producto['porcentajes'] as $porcentaje) {
                    if ($producto['total'] < $porcentaje['hasta'] && $producto['total'] > $porcentaje['desde']) {
                        $producto['porcentajeElejido'] = $porcentaje['porcentaje'];
                    }
                }
            }

            $asientoService = new AsientoService();
            $solicitudes->each(function ($solicitud) use ($productos, $comer, $asientoService) {
                $index = $this->getIndex($solicitud->id_producto, $productos);
                $montoComer = ($solicitud->monto_pagado * $productos[$index]['porcentajeElejido'] / 100) * $comer->getPorcentajeColocacion() / 100;
                $asientoService->crear([
                    ['cuenta' => 311020002, 'debe' => $montoComer, 'haber' => 0],
                    ['cuenta' => 111010201, 'debe' => 0, 'haber' => $montoComer],
                ], '');
                $this->solRepo->update(['estado' => 'Pagada'], $solicitud->id);

            });
        }
    }

    public function comercializadores()
    {
        return $this->repo->comercializadoresConSolicitudesAprobadas();
    }

    public function solicitudesTerminadasComer($id)
    {
        $comer = $this->repo->find($id);
        $solicitudes = $this->repo->solicitudesPendientesDeCobro($comer->getId());

        $productos = array();

        $solicitudes->each(function($solicitud) use (&$productos){
            $index = $this->getIndex($solicitud->id_producto, $productos);
            if($index != -1)
            {
                $productos[$index]['total'] += $solicitud->monto_pagado;
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
            $solicitud['montoACobrar'] = $montoComer;
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
