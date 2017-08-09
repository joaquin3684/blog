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


    public function __construct($id, $entrada, $salida, $fecha, $ganancia)
    {
        $this->id = $id;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->fecha = $fecha;
        $this->ganancia = $ganancia;

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
        $this->salida = $entrada - ($entrada * $ganancia) / 100;
        $this->ganancia = $entrada * $ganancia / 100;
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