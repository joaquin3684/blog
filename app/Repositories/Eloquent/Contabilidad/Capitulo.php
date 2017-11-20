<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 20/11/17
 * Time: 13:28
 */

namespace App\Repositories\Eloquent\Contabilidad;


use App\Repositories\Eloquent\Repos\Gateway\CapituloGateway;
use Illuminate\Http\Request;

class Capitulo
{
    private $id;
    private $codigo;
    private $nombre;
    private $afecta_codigo_base;
    private $rubros;
    private $gateway;

    /**
     * Capitulo constructor.
     * @param $id
     * @param $codigo
     * @param $nombre
     * @param $afecta_codigo_base
     */
    public function __construct($id, $codigo, $nombre, $afecta_codigo_base)
    {
        $this->gateway = new CapituloGateway();
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->afecta_codigo_base = $afecta_codigo_base;
    }

    /**
     * @return mixed
     */
    public function getRubros()
    {
        return $this->rubros;
    }

    /**
     * @param mixed $rubros
     */
    public function setRubros($rubros)
    {
        $this->rubros = $rubros;
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
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
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
    public function getAfectaCodigoBase()
    {
        return $this->afecta_codigo_base;
    }

    /**
     * @param mixed $afecta_codigo_base
     */
    public function setAfectaCodigoBase($afecta_codigo_base)
    {
        $this->afecta_codigo_base = $afecta_codigo_base;
    }

    public function modificarCodigo($request, $offset = 1)
    {
        $this->gateway->update($request, $this->id);
        $this->rubros->each(function(Rubro $rubro ) use ($request, $offset){
           $rubro->modificarCodigo($request, 1, $offset);
        });
    }



}