<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 20:07
 */

namespace App\Repositories\Eloquent;
use App\Traits\Conversion;

class EstadoVenta
{
    use Conversion;

    public $id;
    public $id_venta;
    public $id_responsable_estado;
    public $estado;
    private $observacion;

    public function __construct($id, $id_venta, $id_responsable_estado, $estado, $observacion)
    {
        $this->id = $id;
        $this->id_venta = $id_venta;
        $this->id_responsable_estado = $id_responsable_estado;
        $this->estado = $estado;
        $this->observacion = $observacion;
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

    /**
     * @return mixed
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @param mixed $observacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    }


}