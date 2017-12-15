<?php

namespace App\Http\Controllers;

use App\Imputacion;
use App\Proovedores;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
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
        DB::transaction(function() use ($request){

            $productos = DB::table('proovedores')
                ->join('productos', 'productos.id_proovedor', '=', 'proovedores.id')
                ->join('ventas', 'ventas.id_producto', '=', 'productos.id')
                ->join('cuotas', 'cuotas.cuotable_id', '=', 'ventas.id')
                ->join('movimientos', 'movimientos.identificadores_id', '=', 'cuotas.id')
                ->where('cuotas.cuotable_type', 'App\Ventas')
                ->where('movimientos.identificadores_type', 'App\Cuotas')
                ->where('movimientos.contabilizado_salida', '0')
                ->where('proovedores.id', $request['id_proveedor'])
                ->whereRaw('movimientos.entrada = movimientos.salida')
                ->select('proovedores.id as id_proveedor', 'proovedores.razon_social', 'productos.id as producto')
                ->get();

            $proveedorRepo = new ProveedoresRepo();
            $proveedor = $proveedorRepo->getProveedorConCuotasSinContabilizar($request['id_proveedor']);

            $proveedor = $request['proveedor'];
            $totalAPagar = $request['totalAPagar'];
            $comisionValor = $request['comision'];
            $impuGate = new ImputacionGateway();
            $total = $totalAPagar + $comisionValor;
            $deudor = ImputacionGateway::buscarPorNombre('Deudores '.$proveedor);
            GeneradorDeAsientos::crear($deudor, $totalAPagar, 0);
            $comision = ImputacionGateway::buscarPorNombre('Comisiones '.$proveedor);
            GeneradorDeAsientos::crear($comision, $comisionValor, 0);
            if($request['formaCobro'] == 'banco')
            {
                $banco = $impuGate->find($request['idBanco']);
                GeneradorDeAsientos::crear($banco, 0, $total);
            }
            else if($request['formaCobro'] == 'caja')
            {
                $caja = Imputacion::where('nombre', 'Caja - Efectivo')->first();
                GeneradorDeAsientos::crear($caja, 0, $total);
            }
        });
    }

}
