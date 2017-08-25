<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:52
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repos\SolicitudRepo;
use App\Traits\Conversion;

class Proveedor
{
    use Conversion;
    private $id;
    private $nombre;
    private $descripcion;
    private $prioridad;
    private $productos;
    private $solicitudes;

    public function __construct($id, $nombre, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }

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

    public function generarPropuesta($importe, $montoPorCuota, $cuotas, $idSolicitud)
    {
        $solicitud = $this->getSolicitudes()->first(function($solicitud) use ($idSolicitud){
            return $solicitud->getId() == $idSolicitud;
        });
        $solicitud->setTotal($importe);
        $solicitud->setMontoPorCuota($montoPorCuota);
        $solicitud->setCuotas($cuotas);
        $solicitud->setEstado('Esperando Respuesta Comercializador');
        $solicitud->guardar();
    }

    public function getSolicitudes()
    {
        if($this->solicitudes == null)
        {
            $solRepo = new SolicitudRepo();
            return  $solRepo->buscarPorAgente($this->id);
        } else {
            return $this->solicitudes;
        }
    }

    public function rechazarPropuesta($idSolicitud)
    {
        $solicitud = $this->getSolicitudes()->first(function($solicitud) use ($idSolicitud){
            return $solicitud->getId() == $idSolicitud;
        });
        $solicitud->setEstado('Rechazada por Inversionista');
        $solicitud->guardar();
    }

    public function aceptarPropuesta($idSolicitud)
    {
        $solicitud = $this->getSolicitudes()->first(function($solicitud) use ($idSolicitud){
            return $solicitud->getId() == $idSolicitud;
        });
        $solicitud->setEstado('Aceptada por Comercializador');
        $solicitud->guardar();
    }

    public function reservarCapital($idSolicitud)
    {
        $solicitud = $this->getSolicitudes()->first(function($solicitud) use ($idSolicitud){
            return $solicitud->getId() == $idSolicitud;
        });
        $solicitud->setEstado('Capital Reservado');
        $solicitud->guardar();
    }

    public function otorgarCapital($idSolicitud)
    {
        $solicitud = $this->getSolicitudes()->first(function($solicitud) use ($idSolicitud){
            return $solicitud->getId() == $idSolicitud;
        });
        $solicitud->setEstado('Capital Otorgado');
        $solicitud->guardar();
    }
    /**
     * @return mixed
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * @param mixed $productos
     */
    public function setProductos($productos)
    {
        $this->productos = $productos;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getPrioridad()
    {
        return $this->prioridad->getOrden();
    }

}