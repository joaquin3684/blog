<?php

namespace App\Http\Controllers;

use App\Imputacion;
use App\Proovedores;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoProveedorContable extends Controller
{
    public function index()
    {
        return view('pago_contable_proveedor');
    }

    public function proveedoresImpagos()
    {

            $productos = DB::table('proovedores')
                ->join('productos', 'productos.id_proovedor', '=', 'proovedores.id')
                ->join('ventas', 'ventas.id_producto', '=', 'productos.id')
                ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
                ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
                ->where('cuotas.cuotable_type', 'App\Ventas')
                ->where('movimientos.identificadores_type', 'App\Cuotas')
                ->where('movimientos.contabilizado_salida', '0')
                ->whereRaw('movimientos.entrada = movimientos.salida')
                ->where('movimientos.contabilizado_entrada', '1')
                ->groupBy('productos.id')
                ->select('proovedores.id as id_proveedor', 'proovedores.razon_social', 'productos.id as producto', DB::raw('(SUM(movimientos.salida) * productos.ganancia / 100) as comision , (SUM(movimientos.salida) - (SUM(movimientos.salida) * productos.ganancia / 100)) as totalAPagar'))
                ->get();

            $proveedores = $productos->unique('id_proveedor');
            $p =  $proveedores->map(function($proveedor) use ($productos){
                $productosDeProveedor = $productos->filter(function($producto) use ($proveedor){
                    return $producto->id_proveedor == $proveedor->id_proveedor;
                });
                $proveedor->totalAPagar = $productosDeProveedor->sum('totalAPagar');
                $proveedor->comision = $productosDeProveedor->sum('comision');
                return $proveedor;
            });
            return $p->toArray();

    }


    public function pagar(Request $request)
    {
        DB::transcation(function() use ($request){
            $proveedor = $request['proveedor'];
            $totalAPagar = $request['totalAPagar'];
            $comision = $request['comision'];
            $total = $totalAPagar + $comision;
            $deudor = ImputacionGateway::buscarPorNombre('Deudores '.$proveedor);
            GeneradorDeAsientos::crear($deudor->id, $totalAPagar, 0, $deudor->codigo);
            $comision = ImputacionGateway::buscarPorNombre('Comision '.$proveedor);
            GeneradorDeAsientos::crear($comision->id, $comision, 0, $comision->codigo);
            if($request['formaCobro'] == 'banco')
            {
                GeneradorDeAsientos::crear($request['idBanco'], 0, $total, $request['codigoBanco']);
            }
            else if($request['formaCobro'] == 'caja')
            {
                $caja = Imputacion::where('nombre', 'Caja - Efectivo')->first();
                GeneradorDeAsientos::crear($caja->id, 0, $total, $caja->codigo);
            }
        });
    }

}
