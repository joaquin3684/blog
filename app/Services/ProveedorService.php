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

    private $ventaService;
    public function __construct()
    {
        $this->ventaService = new VentasService();
    }

    public function pagar()
    {
        $proveedores = Proovedores::whereHas('ventas.cuotas.movimientos', function($q){

            $q->where('entrada', '>', 0)
                ->where('salida', '=', 0);
        })->get();

        foreach($proveedores as $proveedor)
        {
            $ventas = $this->ventaService->ventasDeProveedor($proveedor->id);
            foreach ($ventas as $venta)
                $this->ventaService->pagarVenta($venta);
        }

    }










}