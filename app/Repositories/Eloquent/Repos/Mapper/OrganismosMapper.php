<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/05/17
 * Time: 22:09
 */

namespace App\Repositories\Eloquent\Repos\Mapper;


use App\Organismos;
use App\Repositories\Eloquent\Organismo;

class OrganismosMapper
{
    public function __construct()
    {
        $this->sociosMapper = new SociosMapper;
    }

    public function map(Organismos $organismo)
    {
        $organismoNuevo = new Organismo($organismo->id, $organismo->nombre, $organismo->cuit, $organismo->cuota_social);
        if($organismo->relationLoaded('socios'))
        {
            $ventas = $organismo->socios->map(function($socio){
                return $this->sociosMapper->map($socio);
            });
            $organismoNuevo->setVentas($ventas);
        }
        return $organismoNuevo;
    }
}