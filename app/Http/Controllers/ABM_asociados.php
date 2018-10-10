<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Services\ABM_SociosService;
use App\Socios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMsocios;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;
use Illuminate\Support\Facades\DB;

class ABM_asociados extends Controller
{
    private $socio;
    private $service;
    public function __construct(Socio $socio, ABM_SociosService $service)
    {
        $this->socio = $socio;
        $this->service = $service;
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
          $this->service->crearSocio($elem);
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
