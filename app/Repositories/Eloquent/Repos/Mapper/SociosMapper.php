<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/05/17
 * Time: 22:08
 */

namespace App\Repositories\Eloquent\Repos\Mapper;


use App\Repositories\Eloquent\Fechas;
use App\Repositories\Eloquent\Socio;
use App\Socios;

class SociosMapper
{
    private $ventasMapper;
    /**
     * Socio constructor.
     * @param $id
     * @param $nombre
     * @param $fecha_nacimiento
     * @param $cuit
     * @param $dni
     * @param $domicilio
     * @param $localidad
     * @param $codigo_postal
     * @param $telefono
     * @param $fecha_ingreso
     * @param $legajo
     */
    public function __construct()
    {
        $this->ventasMapper = new VentasMapper();
        $this->cuotasMapper = new CuotasMapper();
    }

    public function map(Socios $socio)
    {
        $socioNuevo = new Socio($socio->id, $socio->nombre, $socio->fecha_nacimiento, $socio->cuit, $socio->dni, $socio->domicilio, $socio->localidad, $socio->codigo_postal, $socio->telefono, $socio->fecha_ingreso, $socio->legajo);
        if($socio->relationLoaded('ventas'))
        {
            $ventas = $socio->ventas->map(function($venta){
                return $this->ventasMapper->map($venta);
            });
            $socioNuevo->setVentas($ventas);
        }
        if($socio->relationLoaded('cuotasSociales'))
        {
            $cuotas = $socio->cuotasSociales->map(function($cuota){
                return $this->cuotasMapper->map($cuota);
            });
            $socioNuevo->setCuotasSociales($cuotas);
        }
        return $socioNuevo;
    }


}