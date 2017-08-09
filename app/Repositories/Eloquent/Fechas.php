<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 19:26
 */

namespace App\Repositories\Eloquent;
use Carbon\Carbon;

class Fechas
{
    private static $carbon;

    public function __construct()
    {
        static::$carbon = new Carbon();

    }

    public static function getFechaHoy()
    {
        return Carbon::today()->toDateString();
    }
}