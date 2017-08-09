<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 20:22
 */

namespace App\Repositories\Eloquent;


class Filtros
{
    public function filtrarPorOrganismo($item, $organismo)
    {
        return $item['id_organismo'] == $organismo;
    }

    public function filtrarPorProducto($item, $producto)
    {
        return $item['id_producto'] == $producto;
    }
    // el objeto tiene que ser del tipo Request
    public function filtrosNoNulos($objeto)
    {
        $array = collect();
        foreach($objeto['filtros'] as $obj)
        {
            if(!empty($obj['valor']))
            {
                $array->push($obj);
            }
        }

        return $array;
    }

    public function recursionPorFiltros($arrayDeFiltros, &$arrayAFiltrar)
    {
        if($arrayDeFiltros->count() > 0)
        {
            $filtro = $arrayDeFiltros->shift();
            $funcion = $filtro['funcion'];
            $valor = $filtro['valor'];
            $arrayAFiltrar =  $arrayAFiltrar->filter(function ($item, $key) use ($funcion, $valor){
                return $this->$funcion($item, $valor);
            });
            $this->recursionPorFiltros($arrayDeFiltros, $arrayAFiltrar);
        }
    }

    public function aplicarFiltros($arrayDeFiltros, $array)
    {
        $this->recursionPorFiltros($arrayDeFiltros, $array);
        return $array;
    }
}