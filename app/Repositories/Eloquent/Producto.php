<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:39
 */

namespace App\Repositories\Eloquent;
use App\Traits\Conversion;

class Producto
{
    use Conversion;
    private $id;
    private $nombre;
    private $ganancia;
    private $tipo;
    private $proveedor;
    private $tasa;
    private $ventas;

    public function __construct($id, $nombre, $ganancia, $tipo, $tasa)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ganancia = $ganancia;
        $this->tipo = $tipo;
        $this->tasa = $tasa;
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
    public function getPorcentajeCapital()
    {
        return $this->porcentaje_capital;
    }

    /**
     * @param mixed $porcentaje_capital
     */
    public function setPorcentajeCapital($porcentaje_capital)
    {
        $this->porcentaje_capital = $porcentaje_capital;
    }
    /**
     * @return mixed
     */
    public function getVentas()
    {
        return $this->ventas;
    }

    /**
     * @param mixed $ventas
     */
    public function setVentas($ventas)
    {
        $this->ventas = $ventas;
    }


    /**
     * @return mixed
     */
    public function getProveedor()
    {
        return $this->proveedor;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }

    public function getPrioridad()
    {
        return $this->proveedor->getPrioridad();
    }

    /**
     * @return mixed
     */
    public function getGastosAdministrativos()
    {
        return $this->gastos_administrativos;
    }

    public function contabilizarPago()
    {
        $this->ventas->each(function($venta){
            $venta->contabilizarPago();
        });
    }

    /**
     * @return mixed
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }


}