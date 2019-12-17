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
use App\Services\Utility\MapToModelService;
use App\Socios;
use Carbon\Carbon;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;


class SociosService
{
    private $socio;
    private $organismo;
    private $ventaService;
    public function __construct()
    {
        $this->socio = new Socio();
        $this->organismo = new Organismos();
        $this->ventaService = new VentasService();
    }

    public function crear(
                        $nombre,
                        $fecha_nacimiento,
                        $cuit,
                        $dni,
                        $domicilio,
                        $localidad,
                        $codigo_postal,
                        $telefono,
                        $id_organismo,
                        $legajo,
                        $fecha_ingreso,
                        $sexo,
                        $valor,
                        $piso,
                        $departamento,
                        $nucleo,
                        $estado_civil,
                        $provincia
    )

    {
        $socio = new Socios();
        $socio->nombre = $nombre;
        $socio->fecha_nacimiento = $fecha_nacimiento;
        $socio->cuit = $cuit;
        $socio->dni = $dni;
        $socio->domicilio = $domicilio;
        $socio->localidad = $localidad;
        $socio->codigo_postal = $codigo_postal;
        $socio->telefono = $telefono;
        $socio->id_organismo = $id_organismo;
        $socio->legajo = $legajo;
        $socio->fecha_ingreso = $fecha_ingreso;
        $socio->sexo = $sexo;
        $socio->valor = $valor;
        $socio->piso = $piso;
        $socio->departamento = $departamento;
        $socio->nucleo = $nucleo;
        $socio->estado_civil = $estado_civil;
        $socio->provincia = $provincia;

        $socio->save();
        return $socio;

    }

    public function find($idSocio)
    {
        return Socios::find($idSocio);
    }

    public function cobrar(Socios $socio, $monto)
    {
        $ventas = $this->ventaService->ventasDeSocio($socio->id);
        foreach($ventas as $venta)
        {
            if($monto == 0)
                break;
            $cobrado = $this->ventaService->cobrar($venta, $monto);
            $monto -= $cobrado;
        }
    }
}