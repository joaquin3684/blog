<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 23/04/19
 * Time: 11:36
 */

namespace App\Services;


use App\SubRubro;

class SubRubroService
{
    public function findByCodigo($codigo)
    {
        return SubRubro::where('codigo', $codigo)->first();

    }
}