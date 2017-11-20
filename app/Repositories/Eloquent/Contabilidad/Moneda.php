<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 20/11/17
 * Time: 13:29
 */

namespace App\Repositories\Eloquent\Contabilidad;


use App\Repositories\Eloquent\Repos\Gateway\MonedaGateway;

class Moneda
{
    private $id;
    private $codigo;
    private $nombre;
    private $afecta_codigo_base;
    private $departamentos;
    private $gateway;

    /**
     * Rubro constructor.
     * @param $id
     * @param $codigo
     * @param $nombre
     * @param $afecta_codigo_base
     */
    public function __construct($id, $codigo, $nombre, $afecta_codigo_base)
    {
        $this->gateway = new MonedaGateway();
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->afecta_codigo_base = $afecta_codigo_base;
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


    /**
     * @return mixed
     */
    public function getDepartamentos()
    {
        return $this->departamentos;
    }

    /**
     * @param mixed $departamentos
     */
    public function setDepartamentos($departamentos)
    {
        $this->departamentos = $departamentos;
    }

    public function modificarCodigo($request, $soloCodigo, $start = 3)
    {
        if($soloCodigo == 1) {
            $codigo = $request['codigo'] . substr($this->codigo, $start);
            $this->gateway->update(['codigo' => $codigo], $this->id);
        }
        else
        {
            $this->gateway->update($request, $this->id);
        }
        $this->departamentos->each(function(Departamento $dpto ) use ($request, $start){
            $dpto->modificarCodigo($request, 1, $start);
        });
    }

}