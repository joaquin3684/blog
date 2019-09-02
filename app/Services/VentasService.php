<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/18
 * Time: 15:56
 */

namespace App\Services;


use App\Proovedores;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Carbon\Carbon;

class VentasService
{
    private $cuotasService, $asientoService;

    public function __construct()
    {
        $this->cuotasService = new CuotaService();
        $this->asientoService = new AsientoService();
        $this->productoService = new ProductoService();

    }

    public function crear($id_asociado,
                          $id_producto,
                          $descripcion,
                          $nro_cuotas,
                          $importe_total,
                          $nro_credito,
                          $fecha_vencimiento,
                          $importe_cuota,
                          $importe_otorgado,
                          $id_comercializador
    ){

        $venta = Ventas::create([
                        'id_asociado' => $id_asociado,
                        'id_producto' => $id_producto,
                        'descripcion' => $descripcion,
                        'nro_cuotas' => $nro_cuotas,
                        'importe_total' => $importe_total,
                        'nro_credito' => $nro_credito,
                        'fecha_vencimiento' => $fecha_vencimiento,
                        'importe_cuota' => $importe_cuota,
                        'importe_otorgado' => $importe_otorgado,
                        'id_comercializador' => $id_comercializador
        ]);

        $this->crearCuotasDeVenta($venta);

        $this->contabilizar($venta);

    }

    public function all(){
        return Ventas::with('socio', 'producto.proovedor')->get();
    }
    public function modificar($id_asociado,
                              $id_producto,
                              $descripcion,
                              $nro_cuotas,
                              $importe_total,
                              $nro_credito,
                              $fecha_vencimiento,
                              $importe_cuota,
                              $importe_otorgado,
                              $id_comercializador,
    $idVenta
    )
    {
        $this->borrar($idVenta);
        $this->crear($id_asociado,
            $id_producto,
            $descripcion,
            $nro_cuotas,
            $importe_total,
            $nro_credito,
            $fecha_vencimiento,
            $importe_cuota,
            $importe_otorgado,
            $id_comercializador);
    }

    public function find($id)
    {
        return Ventas::with('cuotas.movimientos')->find($id);
    }

    public function borrar($id)
    {
        $venta = $this->find($id);
        $this->cancelarContabilizacion($venta);
        $this->borrarCuotasDeVenta($venta);
        Ventas::destroy($id);
    }

    public function cancelarContabilizacion(Ventas $venta)
    {
        $producto = $this->productoService->find($venta->id_producto);
        if($producto->proovedor->id == 1)
        {
            $interes = $venta->importe_total - $venta->importe_otorgado;
            $this->asientoService->crear([
                ['cuenta' => 131010001, 'debe' => 0, 'haber' => $venta->importe_otorgado],
                ['cuenta' => 111010201, 'debe' => $venta->importe_otorgado, 'haber' => 0],//TODO hay que ver la seleccion del banco aca
                ['cuenta' => 131010004, 'debe' => 0, 'haber' => $interes],
                ['cuenta' => 131020403, 'debe' => $interes, 'haber' => 0],//TODO hay que ver la seleccion del banco aca
            ], '');

        } else {
            $importe = $venta->importe_total * $producto->ganancia / 100;

            $this->asientoService->crear([
                ['cuenta' => 131010002, 'debe' => 0, 'haber' => $importe],
                ['cuenta' => 131020402, 'debe' => $importe, 'haber' => 0],
            ], '');
        }
    }

    public function contabilizar(Ventas $venta)
    {
        $producto = $this->productoService->find($venta->id_producto);
        if($producto->proovedor->id == 1)
        {
            $interes = $venta->importe_total - $venta->importe_otorgado;
            $this->asientoService->crear([
                ['cuenta' => 131010001, 'debe' => $venta->importe_otorgado, 'haber' => 0],
                ['cuenta' => 111010201, 'debe' => 0, 'haber' => $venta->importe_otorgado],//TODO hay que ver la seleccion del banco aca
                ['cuenta' => 131010004, 'debe' => $interes, 'haber' => 0],
                ['cuenta' => 131020403, 'debe' => 0, 'haber' => $interes],//TODO hay que ver la seleccion del banco aca
            ], '');

        } else {
            $importe = $venta->importe_total * $producto->ganancia / 100;

            $this->asientoService->crear([
                ['cuenta' => 131010002, 'debe' => $importe, 'haber' => 0],
                ['cuenta' => 131020402, 'debe' => 0, 'haber' => $importe],
            ], '');
        }
    }

    public function crearCuotasDeVenta(Ventas $venta)
    {
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $venta->fecha_vencimiento)->subMonths(2);
        $fechaVto = Carbon::createFromFormat('Y-m-d', $venta->fecha_vencimiento);
        for ($i = 1; $venta->nro_cuotas >= $i; $i++) {

            $this->cuotasService->crear($fechaInicio->toDateString(), $fechaVto->toDateString(), $venta->importe_cuota, $i, $venta->id, 'App\Ventas');
            $fechaInicio->addMonth();
            $fechaVto->addMonth();
        }
    }

    public function borrarCuotasDeVenta(Ventas $venta)
    {
        $cuotas = $this->cuotasService->cuotasDeVenta($venta->id);
        foreach ($cuotas as $cuota)
            $this->cuotasService->borrar($cuota->id);

    }

    public function cobrar(Ventas $venta, $monto)
    {

            $cuotas = $this->cuotasService->cuotasDeVenta($venta->id);

            $montoContable = $monto;
            foreach($cuotas as $cuota)
            {
                if($monto == 0)
                    break;
                $cobrado = $this->cuotasService->cobrar($cuota, $monto);
                $monto -= $cobrado;
            }


            $cobrado = $montoContable - $monto;
            $this->contabilizarCobro($cobrado, $venta);

            return $cobrado;


    }

    public function ventasDeSocio($idSocio)
    {
        return Ventas::where('id_asociado', $idSocio)->with('cuotas.movimientos')->get();
    }

    public function ventasDeProveedor($idProveedor)
    {
        return Ventas::with('cuotas.movimientos')->whereHas('producto.proovedor', function($q) use ($idProveedor){
            $q->whereHas('proovedor', function($q) use ($idProveedor){
                $q->where('id', $idProveedor);
            });
        })->get();
    }

    public function contabilizarCobro($montoContableReal, $venta)
    {
        $comisionPagada = 0; // TODO aca hay que calcular la comision del organismo
        $totalBanco = $montoContableReal - $comisionPagada;
        $producto = $this->productoService->find($venta->id_producto);

        if($producto->proovedor->id == 1)
        {

            $interesesACobrar = $montoContableReal * $producto->tasa / 100;
            $prestamosACobrar = $montoContableReal - $interesesACobrar;

            $this->asientoService->crear([
                ['cuenta' => 111010201, 'debe' => $totalBanco, 'haber' => 0],
                ['cuenta' => 521020218, 'debe' => $comisionPagada, 'haber' => 0],//TODO hay que ver la seleccion del banco aca
                ['cuenta' => 131010001, 'debe' => 0, 'haber' => $interesesACobrar],
                ['cuenta' => 131010004, 'debe' => 0, 'haber' => $prestamosACobrar],//TODO hay que ver la seleccion del banco aca
            ], '');


        } else {

            $comisionGanada = $montoContableReal * $producto->ganancia / 100;
            $interesAPagar = $montoContableReal * $producto->tasa / 100;
            $capital = $montoContableReal - $comisionGanada - $interesAPagar;

            $this->asientoService->crear([
                ['cuenta' => 111010201, 'debe' => $totalBanco, 'haber' => 0],
                ['cuenta' => 521020218, 'debe' => $comisionPagada, 'haber' => 0],//TODO hay que ver la seleccion del banco aca
                ['cuenta' => 131010003, 'debe' => 0, 'haber' => $capital],
                ['cuenta' => 131010002, 'debe' => 0, 'haber' => $comisionGanada],//TODO hay que ver la seleccion del banco aca
                ['cuenta' => 311020001, 'debe' => 0, 'haber' => $interesAPagar],//TODO hay que ver la seleccion del banco aca
            ], '');
        }
    }

    public function pagarVenta(Ventas $venta)
    {
        $cuotasImpagas = $this->cuotasService->cuotasImpagas($venta);
        $producto = $this->productoService->find($venta->id_producto);
        $totalPagado = 0;


        foreach($cuotasImpagas as $cuota)
            $totalPagado += $this->cuotasService->pagarCuota($cuota, $producto->ganancia);

        $totalCuotas = $cuotasImpagas->sum(function($cuota){ return $cuota->totalCobrado($cuota);});

        $this->contabilizarPago($totalCuotas, $totalPagado, $producto->tasa);
    }

    public function contabilizarPago($totalCobradoCuotas, $totalPagado, $tasa)
    {

        $interesAPagar = $totalCobradoCuotas * $tasa /100;
        $capital = $totalPagado - $interesAPagar;


        $this->asientoService->crear([
            ['cuenta' => 311020001, 'debe' => $interesAPagar, 'haber' => 0],
            ['cuenta' => 311020003, 'debe' => $capital, 'haber' => 0],
            ['cuenta' => 111010201, 'debe' => 0, 'haber' => $totalPagado],
        ], '');
    }
}