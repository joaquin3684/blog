<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 20:15
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Repos\MovimientosRepo;
use App\Traits\Conversion;
class Movimiento
{
    use Conversion;
    private $id;
    private $id_cuota;
    private $entrada;
    private $salida;
    private $fecha;
    private $ganancia;
    private $contabilizado_salida;
    private $contabilizado_entrada;


    public function __construct($id, $entrada, $salida, $fecha, $ganancia, $contabilizado_salida, $contabilizado_entrada)
    {
        $this->id = $id;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->fecha = $fecha;
        $this->ganancia = $ganancia;
        $this->contabilizado_entrada = $contabilizado_entrada;
        $this->contabilizado_salida = $contabilizado_salida;

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
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * @param mixed $salida
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;
    }

    /**
     * @return mixed
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }

    /**
     * @param mixed $ganancia
     */
    public function setGanancia($ganancia)
    {
        $this->ganancia = $ganancia;
    }

    /**
     * @return mixed
     */
    public function getContabilizadoSalida()
    {
        return $this->contabilizado_salida;
    }

    /**
     * @param mixed $contabilizado_salida
     */
    public function setContabilizadoSalida($contabilizado_salida)
    {
        $this->contabilizado_salida = $contabilizado_salida;
    }

    /**
     * @return mixed
     */
    public function getContabilizadoEntrada()
    {
        return $this->contabilizado_entrada;
    }

    /**
     * @param mixed $contabilizado_entrada
     */
    public function setContabilizadoEntrada($contabilizado_entrada)
    {
        $this->contabilizado_entrada = $contabilizado_entrada;
    }

    public function contabilizarPago()
    {
        $this->contabilizado_salida = 1;
        $this->update($this, $this->id);
    }

    public function getIdCuota()
    {
        return $this->id_cuota;
    }

    public function getEntrada()
    {
        return $this->entrada;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function pagarProovedor($ganancia)
    {
        $entrada = $this->entrada;
        $this->salida = $entrada;
        $this->ganancia = round($entrada * $ganancia /100, 2);
        $this->update($this, $this->id);
    }

    public function update($arr, $id)
    {
        $repo = new MovimientosRepo();
        if(!is_array($arr))
            $arr = get_object_vars($arr);

        $repo->update($arr, $id);
    }
}