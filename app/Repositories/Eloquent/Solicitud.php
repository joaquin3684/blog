<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 18:58
 */

namespace App\Repositories\Eloquent;


use App\Repositories\Eloquent\Repos\SolicitudRepo;
use App\Traits\Conversion;

class Solicitud
{

    private $id;
    private $total;
    private $monto_por_cuota;
    private $cuotas;
    private $doc_endeudamiento;
    private $estado;

    use Conversion;

    public function __construct($id, $total, $montoPorCuota, $cuotas, $doc_endeudamiento = null, $estado )
    {
        $this->id = $id;
        $this->doc_endeudamiento = $doc_endeudamiento;
        $this->estado = $estado;
        $this->cuotas = $cuotas;
        $this->total = $total;
        $this->monto_por_cuota = $montoPorCuota;
        $this->repo  = new SolicitudRepo();

    }

    public function guardar()
    {
        $obj = $this->toArray($this);
        $this->repo->update($obj, $this->id);
    }
    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getMontoPorCuota()
    {
        return $this->monto_por_cuota;
    }

    /**
     * @param mixed $montoPorCuota
     */
    public function setMontoPorCuota($montoPorCuota)
    {
        $this->monto_por_cuota = $montoPorCuota;
    }

    /**
     * @return mixed
     */
    public function getCuotas()
    {
        return $this->cuotas;
    }

    /**
     * @param mixed $cuotas
     */
    public function setCuotas($cuotas)
    {
        $this->cuotas = $cuotas;
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