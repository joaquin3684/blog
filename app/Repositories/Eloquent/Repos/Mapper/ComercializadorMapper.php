<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 19:19
 */

namespace App\Repositories\Eloquent\Repos\Mapper;


use App\Comercializador;
use App\Repositories\Eloquent\Repos\Mapper\SolicitudMapper;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Traits\Conversion;

class ComercializadorMapper
{
    use Conversion;
    private $solicitudesMapper;
    public function __construct()
    {
        $this->solicitudesMapper = new SolicitudMapper();
    }

    public function map(Comercializador $comer)
    {
        $comerNuevo = new \App\Repositories\Eloquent\Comercializador($comer->id);
        if($comer->relationLoaded('solicitudes'))
        {
            $solicitudes = $comer->solicitudes->map(function($solicitud){
                return $this->solicitudesMapper->map($solicitud);
            });
            $comerNuevo->setSolicitudes($solicitudes);
        }
        return $comerNuevo;
    }
}