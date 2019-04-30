<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 23/04/19
 * Time: 19:23
 */

namespace App\Services;


use App\Productos;

class ProductoService
{
    public function find($id)
    {
        return Productos::with('proovedor')->find($id);
    }
}