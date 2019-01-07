<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 13/08/18
 * Time: 15:44
 */
namespace App\Services;


use App\Cuotas;
use App\Organismos;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Socios;
use Carbon\Carbon;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;


class ABM_SociosService
{
    private $socio;
    private $organismo;
    public function __construct()
    {
        $this->socio = new Socio();
        $this->organismo = new Organismos();
    }

    public function crearSocio($elem)
    {

        $fechaInicioCuota = Carbon::today()->toDateString();
        $fechaVencimientoCuota = Carbon::today()->addMonths(2);
        $socio = $this->socio->create($elem);
        $cuotaSocial = $this->organismo->with('cuotas')->find($elem['id_organismo'])->cuotas->first(function($cuota) use ($elem){ return $cuota->categoria == $elem['valor'];});
        $cuota = Cuotas::create([
            'fecha_inicio' => $fechaInicioCuota,
            'fecha_vencimiento' => $fechaVencimientoCuota,
            'importe' => $cuotaSocial->valor,
            'nro_cuota' => 1,
        ]);
        $impuDebe = ImputacionGateway::buscarPorCodigo('131030101');
        $impuHaber = ImputacionGateway::buscarPorCodigo('131030201');
        GeneradorDeAsientos::crear($impuDebe, $elem['valor'], 0);
        GeneradorDeAsientos::crear($impuHaber, 0, $elem['valor']);

        $socio->cuotasSociales()->save($cuota);
    }

    public function cobrar($elem)
    {
        foreach ($elem as $soc) {

            $hoy = Carbon::today()->toDateString();
            $socio = Socios::with(['ventas.cuotas' => function($q) use ($hoy){
                $q->where('fecha_inicio', '<=', $hoy)
                    ->where(function($q){
                        $q->where('estado', 'Cobro Parcial')
                            ->orWhere('estado', null);
                    })

                ->with('movimientos');
            }, 'ventas.producto'])->find($soc['id']);

            $socio->cobrar($soc['monto']);


        }
    }
}