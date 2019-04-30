<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Organismos;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Services\ABM_SociosService;
use App\Services\AsientoService;
use App\Services\CuotaService;
use App\Services\ImputacionService;
use App\Services\SociosService;
use App\Socios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMsocios;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;
use Illuminate\Support\Facades\DB;

class ABM_asociados extends Controller
{
    private $socio;
    private $socioService;
    private $cuotaService;
    private $asientoService;
    public function __construct(Socio $socio, SociosService $service, CuotaService $cuotaService, AsientoService $asientoService)
    {
        $this->socioService = $service;
        $this->cuotaService = $cuotaService;
        $this->socio = $socio;
        $this->asientoService = $asientoService;
    }

    public function index()
    {   
        $registros = $this->socio->all();
        return view('ABM_socios', compact('registros'));
    }

    public function store(ValidacionABMsocios $request)
    {
        $elem = $request->all();
        DB::transaction(function () use ($elem) {
            $socio = $this->socioService->crear(
                $elem['nombre'],
                $elem['fecha_nacimiento'],
                $elem['cuit'],
                $elem['dni'],
                $elem['domicilio'],
                $elem['localidad'],
                $elem['codigo_postal'],
                $elem['telefono'],
                $elem['id_organismo'],
                $elem['legajo'],
                $elem['fecha_ingreso'],
                $elem['sexo'],
                $elem['valor'],
                $elem['piso'],
                $elem['departamento'],
                $elem['nucleo'],
                $elem['estado_civil'],
                $elem['provincia']
            );

            $fechaInicioCuota = Carbon::today()->toDateString();
            $fechaVencimientoCuota = Carbon::today()->addMonths(2)->toDateString();

            $cuotaSocial = Organismos::with('cuotas')->find($elem['id_organismo'])->cuotas->first(function($cuota) use ($elem){ return $cuota->categoria == $elem['valor'];});

            $this->cuotaService->crear($fechaInicioCuota, $fechaVencimientoCuota, $cuotaSocial->valor, 1, $socio->id, 'App\Socios');

            $this->asientoService->crear([
                                    ['cuenta' => 131030101, 'debe' => $cuotaSocial->valor, 'haber' => 0 ],
                                    ['cuenta' => 131030201, 'debe' => 0, 'haber' => $cuotaSocial->valor ],
                ]
            );




        });
        return ['created' => true];
    }

    public function show($id)
    {//TODO: estoy hay que cambiarlo de alguna manera porque en el abm asociados
        //cuando muestro el elemnto deberia poder cambiar de organismo y tambien elejir otra cuota social.
        $socio = Socios::with('organismo.cuotas')->find($id);
        $nombre = explode(",", $socio->nombre);
        $socio->nombre = $nombre[0];
        $socio->apellido = $nombre[1];
        return $socio;
    }

    public function traerElementos()
    {
        return $this->socio->all();
    }

    public function update(ValidacionABMsocios $request, $id)
    {
        $elem = $request->all();
        $elem['nombre'] = $elem['apellido'].','.$elem['nombre'];
        $this->socio->update($elem, $id);
    }

    public function destroy($id)
    {
        $this->socio->destroy($id);
    }

    public function traerDatos()
    {
        return $this->socio->all();
    }
}
