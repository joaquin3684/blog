<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 23:20
 */

namespace App\Repositories\Eloquent;
use App\Socios;
use App\Repositories\Eloquent\CobrarPorSocio;
use App\Traits\Conversion;
class Socio
{
    use Conversion;
    private $ventas;
    private $activeSocio;
    private $id;
    private $nombre;
    private $fecha_nacimiento;
    private $cuit;
    private $dni;
    private $domicilio;
    private $localidad;
    private $codigo_postal;
    private $telefono;
    private $organismo;
    private $fecha_ingreso;
    private $legajo;
    private $grupo_familiar;
    private $cuotasSociales;


    public function __construct($id, $nombre, $fecha_nacimiento, $cuit, $dni, $domicilio, $localidad, $codigo_postal, $telefono, $fecha_ingreso, $legajo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->cuit = $cuit;
        $this->dni = $dni;
        $this->domicilio = $domicilio;
        $this->localidad = $localidad;
        $this->codigo_postal = $codigo_postal;
        $this->telefono = $telefono;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->legajo = $legajo;
    }

    public function setVentas($ventas)
    {
        $this->ventas = $ventas;
    }

    public function getVentas()
    {
        return $this->ventas;
    }

    public function setCuotasSociales($cuotas)
    {
        $this->cuotasSociales = $cuotas;
    }

    public function getCuotasSociales()
    {
        return $this->cuotasSociales;
    }

    public function cuotasSocialesVencidas()
    {
        return $this->cuotasSociales->filter(function ($cuota){
            return $cuota->estaVencida();
        });
    }
    /**
     * @return Socios
     */
    public function getActiveSocio()
    {
        return $this->activeSocio;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @return mixed
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @return mixed
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @return mixed
     */
    public function getCodigoPostal()
    {
        return $this->codigo_postal;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return mixed
     */
    public function getOrganismo()
    {
        return $this->organismo;
    }

    /**
     * @return mixed
     */
    public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

    /**
     * @return mixed
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * @return mixed
     */
    public function getGrupoFamiliar()
    {
        return $this->grupo_familiar;
    }



}