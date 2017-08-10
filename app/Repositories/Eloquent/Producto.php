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

    public function __construct($id, $nombre, $ganancia, $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;

        $this->ganancia = $ganancia;
        $this->tipo = $tipo;
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

    /**
     * @return mixed
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }


}