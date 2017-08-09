<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;
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

    public function __construct()
    {
        $this->comerRepo = new ComercializadorRepo();
        $this->solicitudGateway = new SolicitudGateway();
        $this->agenteMapper = new AgenteFinancieroMapper();
        $this->comerGateway = new ComercializadorGateway();
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
        $elementos = $request->all();
        $nombre            = $elementos['nombre'];
        $apellido          = $elementos['apellido'];
        $cuit              = $elementos['cuit'];
        $domicilio         = $elementos['domicilio'];
        $telefono          = $elementos['telefono'];
        $codigo_postal     = $elementos['codigo_postal'];
        $doc_documento     = $elementos['doc_documento'];
        $doc_recibo        = $elementos['doc_recibo'];
        $doc_domicilio     = $elementos['doc_domicilio'];
        $doc_cbu           = $elementos['doc_cbu'];
        $doc_endeudamiento = $elementos['doc_endeudamiento'];


        $filtro = $elementos['filtro'] == '' ? [] : $elementos['filtro'];
       // $a = Sentinel::authenticate(['usuario' => $elementos['usuario'], 'password' => $elementos['password']]);
        $usuario = Sentinel::check();

        //TODO::falta mover los archivos;
        $agentes = DB::table('agentes_financieros')
            ->select('agentes_financieros.*');

        $agentesFiltrados = \App\Repositories\Eloquent\Filtros\AgentesFinancierosFilter::apply($filtro, $agentes);

        $agentes = $agentesFiltrados->map(function($agente){
           return $this->agenteMapper->map($agente);
        });

        $comercializador = $this->comerRepo->findByUser($usuario->usuario);
        $comercializador->generarSolicitud($nombre, $apellido, $cuit, $domicilio, $telefono, $codigo_postal, $doc_documento, $doc_recibo, $doc_domicilio, $doc_cbu, $doc_endeudamiento, $agentes);
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $comercializador = $this->comerGateway->findSolicitudesFromUser($usuario->usuario);
        return $comercializador->solicitudes();
    }


    public function modificarPropuesta(Request $request)
    {
        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
    }



}
