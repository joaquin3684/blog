<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\DesignadorDeEstado;
use App\Repositories\Eloquent\DesignarAgenteFinanciero;
use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;
use App\Repositories\Eloquent\Repos\Mapper\ProveedoresMapper;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SolicitudesSinInversionistaRepo;
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

    public function __construct()
    {
        $this->comerRepo = new ComercializadorRepo();
        $this->solicitudGateway = new SolicitudGateway();
        $this->proovedorMapper = new ProveedoresMapper();
        $this->comerGateway = new ComercializadorGateway();
        $this->proveedorRepo = new ProveedoresRepo();
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
        $col = collect($request->all());
        $filtro = $elementos['filtro'] == '' ? [] : $elementos['filtro'];

        $a = Sentinel::authenticate(['usuario' => $elementos['usuario'], 'password' => $elementos['password']]);
        $usuario = Sentinel::check();

        //TODO::falta mover los archivos;
        $agentes = DB::table('proovedores')
            ->join('productos', 'proovedores.id', '=', 'productos.id_proovedor')
            ->where('productos.tipo', 'Credito')
            ->select('proovedores.*', 'productos.tipo');

        $agentesFiltrados = \App\Repositories\Eloquent\Filtros\ProovedoresFilter::apply($filtro, $agentes);

        $agentes = $agentesFiltrados->map(function($agente){
           return $this->proveedorRepo->find($agente->id);
        });

        $comercializador = $this->comerRepo->findByUser($usuario->usuario);
        $comercializador->generarSolicitud($col, $agentes);

    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $comercializador = $this->comerGateway->findSolicitudesFromUser($usuario->usuario);
        return $comercializador->solicitudes;
    }


    public function modificarPropuesta(Request $request)
    {
        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
    }



}
