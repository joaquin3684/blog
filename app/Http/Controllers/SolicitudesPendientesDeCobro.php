<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

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
           $montoComer = ($solicitud->total * $productos['porcentajeElejido'] /100) * $comer->porcentaje_colocacion /100;
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
