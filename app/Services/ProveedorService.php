<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/18
 * Time: 21:43
 */

namespace App\Services;


use App\Proovedores;
use App\Solicitud;
use App\Ventas;

class ProveedorService
{
    public function pagar()
    {
        $proveedores = Proovedores::with(['ventas' => function($q){
            $q->whereHas('cuotas.movimientos', function($q){
                $q->where('entrada', '>', 0)
                    ->where('salida', '=', 0);
            })
                ->with('cuotas.movimientos');

            }]
        , 'ventas.producto')->whereHas('ventas.cuotas.movimientos', function($q){

            $q->where('entrada', '>', 0)
                ->where('salida', '=', 0);
        })->get();

        $proveedores->each(function ($prov) {
            $prov->cobrar();
        });

    }









}