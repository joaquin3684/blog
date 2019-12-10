<?php

namespace App\Http\Controllers;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Notifications\SolicitudAceptada;
use App\Notifications\SolicitudContraPropuestada;
use App\Notifications\SolicitudEnProceso;
use App\Notifications\SolicitudFormularioEnviado;
use App\Repositories\Eloquent\DesignadorDeEstado;
use App\Repositories\Eloquent\DesignarAgenteFinanciero;
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;
use App\Repositories\Eloquent\Repos\Mapper\ProveedoresMapper;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SolicitudesSinInversionistaRepo;
use App\Services\ComercializadorService;
use App\Services\SolicitudService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Compilers\BladeCompiler;

class ComercializadorController extends Controller
{
    private $comerRepo;
    private $solicitudGateway;
    private $comerGateway;
    private $proovedorMapper;
    private $service;
    private $solService;

    public function __construct()
    {
        $this->comerRepo = new ComercializadorRepo();
        $this->solicitudGateway = new SolicitudGateway();
        $this->proovedorMapper = new ProveedoresMapper();
        $this->comerGateway = new ComercializadorGateway();
        $this->proveedorRepo = new ProveedoresRepo();
        $this->service = new ComercializadorService();
        $this->solService = new SolicitudService();
    }

    public function index()
    {
        return view('comercializador');
    }

    /**
     * @param Request $request
     */
    public function altaSolicitud(Request $request)
    {
        DB::transaction(function () use ($request){

            $solicitud = $this->service->generarSolicitud($request->all());

            $ruta = 'solicitudes/solicitud'.$solicitud->id;

            $doc_endeudamiento = $request->hasFile('doc_endeudamiento') ? $request->doc_endeudamiento : null;
            $doc_domicilio = $request->doc_domicilio;
            $doc_recibo = $request->doc_recibo;
            $doc_cbu = $request->doc_cbu;
            $doc_documento = $request->doc_documento;

            FileManager::uploadImage($doc_domicilio, $ruta, 'doc_domicilio.png');
            FileManager::uploadImage($doc_recibo, $ruta, 'doc_recibo.png');
            FileManager::uploadImage($doc_cbu, $ruta, 'doc_cbu.png');
            FileManager::uploadImage($doc_documento, $ruta, 'doc_documento.png');
            if($request->hasFile('doc_endeudamiento'))
            {
                FileManager::uploadImage($doc_endeudamiento, $ruta, 'doc_endeudamiento.png');
            }

        });
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $comercializador = $this->comerGateway->findSolicitudesFromUser($usuario->id);
        if ($comercializador != null) {
            return $comercializador->solicitudes;
        }
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

    public function modificarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->solService->modificarSolicitud($request->all());
        });

    }

    public function rechazarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->solService->modificarSolicitud($request->all());

        });
    }


    public function enviarFormulario(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->solService->modificarSolicitud($request->all());
        });
    }

    public function aceptarPropuesta(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->solService->modificarSolicitud($request->all());
        });
    }

    public function sociosQueCumplenConFiltro(Request $request)
    {
        $socios = DB::table('socios')
            ->where('id_organismo', $request['id_organismo'])
            ->where('nombre', 'LIKE', '%'.$request['nombre'].'%')
            ->where('deleted_at', null)->get();
        return $socios;
    }



}
