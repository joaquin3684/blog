<?php

namespace App\Http\Controllers;

use App\Cuotas;
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
            $socio->cuotasSociales()->save($cuota);
        });
        return ['created' => true];
    }

    public function show($id)
    {
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
