<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Socios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMsocios;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;
use Illuminate\Support\Facades\DB;

class ABM_asociados extends Controller
{
    private $socio;

    public function __construct(Socio $socio)
    {
        $this->socio = $socio;
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
            $fechaInicioCuota = Carbon::today()->toDateString();
            $fechaVencimientoCuota = Carbon::today()->addMonths(2);
            $socio = $this->socio->create($elem);
            $cuota = Cuotas::create([
                'fecha_inicio' => $fechaInicioCuota,
                'fecha_vencimiento' => $fechaVencimientoCuota,
                'importe' => $elem['valor'],
                'nro_cuota' => 1,
            ]);
            $impu = ImputacionGateway::buscarPorCodigo('511010101');
            GeneradorDeAsientos::crear($impu, 0, $elem['valor']);
            GeneradorDeAsientos::crear($impu, $elem['valor'], 0);

            //todo la imputacion al debe queda pendiente no saben que cuenta es todavia
            $socio->cuotasSociales()->save($cuota);
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
        return $this->socio->all()->map(function($socio){
            $nombre = explode(",", $socio->nombre);
            $socio->nombre = $nombre[0];
            $socio->apellido = $nombre[1];
            return $socio;
        });
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
