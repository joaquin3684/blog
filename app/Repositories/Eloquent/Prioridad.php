<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:54
 */

namespace App\Repositories\Eloquent;


class Prioridad
{
    private $id;
    private $nombre;
    private $orden;

    public function __construct($id, $nombre, $orden)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->orden = $orden;
    }

    public function getOrden()
    {
        return $this->orden;
    }



}