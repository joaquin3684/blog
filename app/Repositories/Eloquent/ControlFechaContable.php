<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/10/17
 * Time: 15:25
 */

namespace App\Repositories\Eloquent;


use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\ControlFechaContable as FechaContable;
class ControlFechaContable
{
    public $fechaContable;
    public static $fecha;
    public function __construct()
    {
        $user = Sentinel::check();
        $fecha = FechaContable::where('id_usuario', $user->id)->first();
        $this->fechaContable = $fecha == null ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $fecha);

    }

    public static function getFecha()
    {
        $user = Sentinel::check();
        $fecha = FechaContable::where('id_usuario', $user->id)->first();
        return $fecha == null ? Carbon::today()->toDateString() : $fecha->fecha_contable;
    }

}