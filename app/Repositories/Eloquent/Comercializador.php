<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 18:37
 */

namespace App\Repositories\Eloquent;


use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\SolicitudesSinInversionistaRepo;
use App\Repositories\Eloquent\Repos\SolicitudRepo;

class Comercializador
{
    private $solicitudes;
    private $id;
    private $nombre;
    private $dni;
    private $cuit;
    private $telefono;
    private $usuario;
    private $apellido;
    private $domicilio;
    private $email;
    private $porcentaje_colocacion;

    /**
     * Comercializador constructor.
     * @param $id
     * @param $nombre
     * @param $dni
     * @param $cuit
     * @param $telefono
     * @param $usuario
     * @param $apellido
     * @param $domicilio
     * @param $email
     * @param $porcentaje_colocacion
     */
    public function __construct($id, $nombre, $dni, $cuit, $telefono, $usuario, $apellido, $domicilio, $email, $porcentaje_colocacion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->cuit = $cuit;
        $this->telefono = $telefono;
        $this->usuario = $usuario;
        $this->apellido = $apellido;
        $this->domicilio = $domicilio;
        $this->email = $email;
        $this->porcentaje_colocacion = $porcentaje_colocacion;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @param mixed $cuit
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param mixed $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPorcentajeColocacion()
    {
        return $this->porcentaje_colocacion;
    }

    /**
     * @param mixed $porcentaje_colocacion
     */
    public function setPorcentajeColocacion($porcentaje_colocacion)
    {
        $this->porcentaje_colocacion = $porcentaje_colocacion;
    }



    public function generarSolicitud($solicitud, $agentesFiltrados)
    {
        if(!$solicitud->has('id_socio'))
        {
            $socioRepo = new SociosRepo();
            $socio = $socioRepo->create($solicitud->toArray());
            $solicitud->put('id_socio', $socio->getId());
            $socioRepo->destroy($socio->getId());
        }

        $solicitud->put('estado', 'Procesando Solicitud');
        $solicitud->put('comercializador', $this->id);

        $repoSolicitud = new SolicitudRepo();
        $solicitud =  $repoSolicitud->create($solicitud->toArray());
        $this->addSolicitud($solicitud);

        $repo = new SolicitudesSinInversionistaRepo();

        $agentesFiltrados->each(function($agente) use ($solicitud, $repo){
            $repo->create(['solicitud' => $solicitud->getId(), 'agente_financiero' => $agente->getId()]);
        });


        return $solicitud;


    }

    public function addSolicitud($solicitud)
    {
        $this->solicitudes->push($solicitud);
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

    /**
     * @param \Illuminate\Support\Collection|null $solicitudes
     */
    public function setSolicitudes($solicitudes)
    {
        $this->solicitudes = $solicitudes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}