<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 18:58
 */

namespace App\Repositories\Eloquent;


class Solicitud
{
    private $nombre;
    private $apellido;
    private $cuit;
    private $domicilio;
    private $telefono;
    private $codigo_postal;
    private $id;
    private $doc_documento;
    private $doc_recibo;
    private $doc_domicilio;
    private $doc_cbu;
    private $doc_endeudamiento;
    private $estado;


    public function __construct($id, $nombre, $apellido, $cuit, $domicilio, $telefono, $codigo_postal, $doc_documento, $doc_recibo, $doc_domicilio, $doc_cbu, $doc_endeudamiento = null, $estado )
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cuit = $cuit;
        $this->domicilio = $domicilio;
        $this->telefono = $telefono;
        $this->codigo_postal = $codigo_postal;
        $this->doc_endeudamiento = $doc_endeudamiento;
        $this->doc_cbu = $doc_cbu;
        $this->doc_domicilio = $doc_domicilio;
        $this->doc_recibo = $doc_recibo;
        $this->doc_documento = $doc_documento;
        $this->estado = $estado;


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
    public function getCodigoPostal()
    {
        return $this->codigo_postal;
    }

    /**
     * @param mixed $codigo_postal
     */
    public function setCodigoPostal($codigo_postal)
    {
        $this->codigo_postal = $codigo_postal;
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

    /**
     * @return mixed
     */
    public function getDocDocumento()
    {
        return $this->doc_documento;
    }

    /**
     * @param mixed $doc_documento
     */
    public function setDocDocumento($doc_documento)
    {
        $this->doc_documento = $doc_documento;
    }

    /**
     * @return mixed
     */
    public function getDocRecibo()
    {
        return $this->doc_recibo;
    }

    /**
     * @param mixed $doc_recibo
     */
    public function setDocRecibo($doc_recibo)
    {
        $this->doc_recibo = $doc_recibo;
    }

    /**
     * @return mixed
     */
    public function getDocDomicilio()
    {
        return $this->doc_domicilio;
    }

    /**
     * @param mixed $doc_domicilio
     */
    public function setDocDomicilio($doc_domicilio)
    {
        $this->doc_domicilio = $doc_domicilio;
    }

    /**
     * @return mixed
     */
    public function getDocCbu()
    {
        return $this->doc_cbu;
    }

    /**
     * @param mixed $doc_cbu
     */
    public function setDocCbu($doc_cbu)
    {
        $this->doc_cbu = $doc_cbu;
    }

    /**
     * @return null
     */
    public function getDocEndeudamiento()
    {
        return $this->doc_endeudamiento;
    }

    /**
     * @param null $doc_endeudamiento
     */
    public function setDocEndeudamiento($doc_endeudamiento)
    {
        $this->doc_endeudamiento = $doc_endeudamiento;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


}