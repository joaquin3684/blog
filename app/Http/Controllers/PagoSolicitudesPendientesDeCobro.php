<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoSolicitudesPendientesDeCobro extends Controller
{
    public function index()
    {
        return view('pagoSolicitudesPendientesDeCobro');
    }

    public function pagar(Request $request)
    {

        $solicitudes = $this->repo->findSolicitudesPendientesDeCobro($comer->getId());

        $productos = array();

        $solicitudes->groupBy('id_producto');
        $solicitudes->each(function($solicitud) use ($productos){
            $index = $this->getIndex($solicitud->id_producto, $productos);
            if($index != -1)
            {
                $productos[$index]['total'] += $solicitud->total;
            } else {
                $producto = array('id' => $solicitud->id_producto, 'total' => $solicitud->total, 'porcentajes', $solicitud->producto->porcentajes);
                array_push($productos, $producto);
            }
        });

        foreach($productos as $producto) {

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
            $montoComer = ($solicitud->total * $productos[$index]['porcentajeElejido'] /100) * $comer->porcentaje_colocacion /100;
            $solicitud['montoACobrar'] = $montoComer;
        });

    }
}
