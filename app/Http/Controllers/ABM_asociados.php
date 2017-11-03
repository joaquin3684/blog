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
            GeneradorDeAsientos::crear($impu->id, 0, $elem['valor'], $impu->codigo);
            GeneradorDeAsientos::crear($impu->id, $elem['valor'], 0, $impu->codigo);

            //todo la imputacion al debe queda pendiente no saben que cuenta es todavia
            $socio->cuotasSociales()->save($cuota);
        });
        return ['created' => true];
    }

    public function show($id)
    {//TODO: estoy hay que cambiarlo de alguna manera porque en el abm asociados
        //cuando muestro el elemnto deberia poder cambiar de organismo y tambien elejir otra cuota social.
        return Socios::with('organismo.cuotas')->find($id);
    }

    public function traerElementos()
    {
        return $this->socio->all();
    }

    public function update(ValidacionABMsocios $request, $id)
    {
        $this->socio->update($request->all(), $id);
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
