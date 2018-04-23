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

    public function __construct()
    {
        $this->solicitudGateway = new SolicitudGateway();
        $this->agenteGateway = new ProveedoresGateway();
    }

    public function index()
    {
        return view('agente_financiero');
    }

    public function generarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $importe = $request['total'];
            $montoPorCuota = $request['monto_por_cuota'];
            $cuotas = $request['cuotas'];
            $solicitud = $request['id'];
            $usuario = Sentinel::check();
            $agenteRepo = new ProveedoresRepo();
            $proveedor = $agenteRepo->findByUser($usuario->id);
            $proveedor->generarPropuesta($importe, $montoPorCuota, $cuotas, $solicitud);
        });
    }

    public function rechazarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $solicitud = $request['id'];
            $usuario = Sentinel::check();
            $agenteRepo = new ProveedoresRepo();
            $proveedor = $agenteRepo->findByUser($usuario->id);
            $proveedor->rechazarPropuesta($solicitud);
        });
    }

    public function aceptarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $solicitud = $request['id'];
            $usuario = Sentinel::check();
            $agenteRepo = new ProveedoresRepo();
            $proveedor = $agenteRepo->findByUser($usuario->id);
            $proveedor->aceptarPropuesta($solicitud);
        });
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero($usuario->id);
        return $agente->solicitudes->map(function($solicitud){
            $socio = $solicitud->socio;
            $nombre = explode(",", $socio->nombre);
            $socio->nombre = $nombre[0];
            $socio->apellido = $nombre[1];
            $solicitud->socio = $socio;
            return $solicitud;
        });
    }

    public function reservarCapital(Request $request)
    {
        DB::transaction(function () use ($request) {
            $elem = $request->all();
            $solicitud = $elem['id'];
            $usuario = Sentinel::check();
            $agenteRepo = new ProveedoresRepo();
            $proveedor = $agenteRepo->findByUser($usuario->id);
            $proveedor->reservarCapital($solicitud);
        });

    }

    public function otorgarCapital(Request $request)
    {
        DB::transaction(function () use ($request) {
            $elem = $request->all();
            $solicitud = $elem['id'];
            $usuario = Sentinel::check();
            $agenteRepo = new ProveedoresRepo();
            $proveedor = $agenteRepo->findByUser($usuario->id);
            $proveedor->otorgarCapital($solicitud);

        });
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
