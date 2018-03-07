<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use App\Repositories\Eloquent\Repos\SolicitudRepo;
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

            $comer = $this->repo->findByUser($comer['id']);
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

            $solicitudes->each(function ($solicitud) use ($productos, $comer) {
                $index = $this->getIndex($solicitud->id_producto, $productos);
                $montoComer = ($solicitud->total * $productos[$index]['porcentajeElejido'] / 100) * $comer->getPorcentajeColocacion() / 100;
                $this->solRepo->update(['monto_pagado' => $montoComer], $solicitud->id);

            });
        }
    }
}
