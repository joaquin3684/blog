<?php

namespace App\Http\Controllers;

use App\Notifications\SolicitudAceptada;
use App\Notifications\SolicitudCapitalOtorgado;
use App\Notifications\SolicitudCapitalReservado;
use App\Notifications\SolicitudPropuesta;
use App\Notifications\SolicitudRechazada;
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\SolicitudRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Repositories\Eloquent\Socio;
use App\Services\ProveedorService;
use App\Services\SolicitudService;
use App\Socios;
use App\Solicitud;
use App\Traits\FechasManager;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AgenteFinancieroController extends Controller
{
    use FechasManager;

    private $solicitudGateway;
    private $agenteGateway;
    private $service;
    private $solService;

    public function __construct()
    {
        $this->solicitudGateway = new SolicitudGateway();
        $this->agenteGateway = new ProveedoresGateway();

        $this->service = new ProveedorService();
        $this->solService = new SolicitudService();
    }

    public function index()
    {
        return view('agente_financiero');
    }

    public function generarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {

            $this->solService->modificarSolicitud($request->all());

        });
    }

    public function rechazarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $request['estado'] = 'Rechazada por Inversionista';
            $this->solService->modificarSolicitud($request->all());
        });
    }

    public function aceptarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $request['estado'] = 'Aceptada por comercializador';
            $this->solService->modificarSolicitud($request->all());

        });
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero($usuario->id);
        return $agente->solicitudes->map(function($solicitud){
            $solNueva = $solicitud;
            $socio = $solNueva->socio;
            $solNueva->socio = $socio;
            $s = new Socios($socio->toArray());
            $nombre = explode(",", $socio->nombre);
            $s->nombre = $nombre[0];
            $s->apellido = $nombre[1];
            $solicitud->socio = $s;
            return $solicitud;
        });
    }

    public function reservarCapital(Request $request)
    {
        DB::transaction(function () use ($request) {

            $request['estado'] = 'Capital Reservado';
            $this->solService->modificarSolicitud($request->all());
        });

    }

    public function otorgarCapital(Request $request)
    {
        DB::transaction(function () use ($request) {

            $request['estado'] = 'Capital Otorgado';
            $this->solService->modificarSolicitud($request->all());
        });
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
