<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/08/17
 * Time: 16:13
 */

namespace App\Repositories\Eloquent\Cobranza\Agrupacion;


use Illuminate\Support\Collection;

class AgruparPorOrdenDePrioridad
{
    public static function agrupar(Collection $col)
    {
        return $col->groupBy(function($item){
                    return $item->orden;
                })->sortBy(function($item, $key){
                     return $key;
                });
    }
}