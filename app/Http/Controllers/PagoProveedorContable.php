<?php

namespace App\Http\Controllers;

use App\Proovedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoProveedorContable extends Controller
{
    public function index()
    {
        return view('pago_contable');
    }

    public function proveedoresImpagos()
    {
        DB::transcation(function(){
            $proveedores = DB::table('proovedores')
                ->join('productos', 'productos.id_proovedor', '=', 'proovedores.id')
                ->join('ventas', 'ventas.id_producto', '=', 'productos.id')
                ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
                ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
                ->where('cuotas.cuotable_type', 'App\Ventas')
                ->where('movimientos.identificadores_type', 'App\Cuotas')
                ->where('movimientos.entrada', 'movimientos.salida')
                ->where('movimientos.contabilizado_salida', '0')
                ->where('movimientos.contabilizado_entrada', '1')
                ->groupBy('productos.id')
                ->select('proovedores.id', 'proovedores.razon_social', 'productos.id as producto', DB::raw('SUM(movimientos.salida) * producto.ganancia'))
                ->get();

            $proveedores->map(function($proveedor) use ($proveedores){
                $proveedores->filter(function($prove) use ($proveedor){
                    return $prove
                })
            });
        });
    }


    public function informacionPago(Request $request)
    {
        DB::transcation(function() use ($request){
            $proveedor = $request['proveedor'];

        });
    }

    public function pagar(Request $request)
    {
        DB::transcation(function() use ($request){
           $proveedor = $request['proveedor'];

        });
    }
}
