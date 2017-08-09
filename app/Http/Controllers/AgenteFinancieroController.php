<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;


class AgenteFinancieroController extends Controller
{
    private $solicitudGateway;
    private $agenteGateway;

    public function __construct()
    {
        $this->solicitudGateway = new SolicitudGateway();
        $this->agenteGateway = new AgenteFinancieroGateway();
    }

    public function index()
    {
        return view('agente_financiero');
    }

    public function accionesSobrePropuesta(Request $request)
    {
        //este metodo ataja todas las acciones de la propeusta y sus cambios de estado

        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero($usuario->usuario);
        return $agente->solicitudes();
    }

    public function reservarCapital(Request $request)
    {
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
    }

    public function otorgarCapital(Request $request)
    {
        $socioRepo = new SociosRepo();
        $ventasRepo = new VentasRepo();
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $sol = $this->solicitudGateway->update($elem, $elem['id']);

        $idOrganismo = $sol->organismo;
        $nombre = $sol->nombre;
        $apellido = $sol->apellido;
        $cuit = $sol->cuit;
        $domicilio = $sol->domicilio;
        $codigo_postal = $sol->codigo_postal;

        $col = collect();
        $col->put('id_organismo', $idOrganismo);
        $col->put('nombre', $nombre);
        $col->put('apellido', $apellido);
        $col->put('cuit', $cuit);
        $col->put('domicilio', $domicilio);
        $col->put('codigo_postal', $codigo_postal);

        $socioRepo->create($col->toArray());

        $ventasRepo


    }

}
