<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 22:57
 */


namespace App\Repositories\Eloquent;
use App\Traits\Conversion;

class Organismo
{
    use Conversion;
    private $socios;
    private $id;
    private $nombre;
    private $cuit;
    private $cuota_social;

    public function __construct($id, $nombre, $cuit, $cuota_social)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cuit = $cuit;
        $this->cuota_social = $cuota_social;
    }

    public function buscarOrganismo($id)
    {
        return $this->organismoMapper->map($id);
    }

    public function getSocios()
    {
        return $this->socios;
    }



}