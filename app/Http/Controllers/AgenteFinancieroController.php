<?php

namespace App\Http\Controllers;

use App\Notifications\SolicitudPropuesta;
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
        $importe = $request['total'];
        $montoPorCuota = $request['monto_por_cuota'];
        $cuotas = $request['cuotas'];
        $solicitud = $request['id'];
        $solicitudRepo = new SolicitudGateway();
        $sol = $solicitudRepo->solicitudWithComer($solicitud);
        $usuario = Sentinel::check();
        $agenteRepo = new ProveedoresRepo();
        $proveedor = $agenteRepo->findByUser($usuario->id);
        $proveedor->generarPropuesta($importe, $montoPorCuota, $cuotas, $solicitud);
        $comer = $sol->comercializador;
        $userANotif = Sentinel::findById($comer->usuario);
        $userANotif->notify(new SolicitudPropuesta($sol));

    }

    public function rechazarPropuesta(Request $request)
    {
        $solicitud = $request['id'];
        $usuario = Sentinel::check();
        $agenteRepo = new ProveedoresRepo();
        $proveedor = $agenteRepo->findByUser($usuario->id);
        $proveedor->rechazarPropuesta($solicitud);
    }

    public function aceptarPropuesta(Request $request)
    {
        $solicitud = $request['id'];
        $usuario = Sentinel::check();
        $agenteRepo = new ProveedoresRepo();
        $proveedor = $agenteRepo->findByUser($usuario->id);
        $proveedor->aceptarPropuesta($solicitud);
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero($usuario->id);
        return $agente->solicitudes;
    }

    public function reservarCapital(Request $request)
    {
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $usuario = Sentinel::check();
        $agenteRepo = new ProveedoresRepo();
        $proveedor = $agenteRepo->findByUser($usuario->id);
        $proveedor->reservarCapital($elem['id']);

    }

    public function otorgarCapital(Request $request)
    {
        $elem = $request->all();
        $usuario = Sentinel::check();
        $agenteRepo = new ProveedoresRepo();
        $proveedor = $agenteRepo->findByUser($usuario->id);
        $proveedor->otorgarCapital($elem['id']);
    }




    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
