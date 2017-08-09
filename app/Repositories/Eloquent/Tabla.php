<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 20:33
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Filtros;
use Yajra\Datatables\Facades\Datatables;
class Tabla
{
    private $filtros;
    public function __construct(Filtros $filtros)
    {
        $this->filtros = $filtros;
    }
 // TODO:fijarse como hacer la implementacion para cualquier tipo de query, es decir si es por querybuilder o por colleciones
    public function generarTabla($request, $datos)
    {
        $filtros = $this->filtros->filtrosNoNulos($request);
        return  $tabla =  Datatables::of($datos)
            ->filter(function ($instance) use ($filtros){
                $instance->collection = $this->filtros->aplicarFiltros($filtros, $instance->collection);

            })
            ->make(true);
    }
}