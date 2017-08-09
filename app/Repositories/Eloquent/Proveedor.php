<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:52
 */

namespace App\Repositories\Eloquent;
use App\Traits\Conversion;

class Proveedor
{
    use Conversion;
    private $id;
    private $nombre;
    private $descripcion;
    private $prioridad;

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

    public function getPrioridad()
    {
        return $this->prioridad->getOrden();
    }

}