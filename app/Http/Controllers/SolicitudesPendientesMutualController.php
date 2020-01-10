<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Notifications\SolicitudAsignada;
use App\Productos;
use App\Proovedores;
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Generadores\GeneradorVenta;
use App\Repositories\Eloquent\GeneradorNumeroCredito;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudesSinInversionistaGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Services\ProveedorService;
use App\Services\SolicitudService;
use App\Services\VentasService;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesPendientesMutualController extends Controller
{
    private $solicitudesGateway;
    private $solService;
    public function __construct()
    {
        $this->solicitudesGateway = new SolicitudGateway();
        $this->solService = new SolicitudService();
    }

    public function index()
    {
        return view('solicitudes_pendientes_mutual');
    }

    public function actualizar(Request $request)
    {
        DB::transaction(function () use ($request) {
            $elem = $request->all();
            $col = collect();
            if ($request->has('doc_endeudamiento')) {
                $endeudamiento = $elem['doc_endeudamiento'];
                $col->put('doc_endeudamiento', $endeudamiento);

            }
            if ($request->has('agente_financiero')) {
                $agente = $elem['agente_financiero'];
                $producto = $elem['id_producto'];
                $col->put('agente_financiero', $agente);
                $col->put('id_producto', $producto);

            }

            $sol = $this->solicitudesGateway->update($col->toArray(), $elem['id']);
            $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Agente Financiero Asignado' : 'Procesando Solicitud';
            $sol->save();


        });
    }

    public function solicitudes()
    {
        return $this->solicitudesGateway->solicitudesSinAsignar()->map(function($solicitud){
            $socio = $solicitud->socio;
            $nombre = explode(",", $socio->nombre);
            $socioNuevo = $socio->replicate();
            $socioNuevo->nombre = $nombre[0];
            $socioNuevo->apellido = $nombre[1];
            $solicitud->socio = $socioNuevo;
            return $solicitud;
    });
    }

    public function proveedores(Request $request)
    {
        return Proovedores::all();
    }

    public function solicitudesAVerificar()
    {
        return $this->solicitudesGateway->solicitudesConCapitalOtorgado()->map(function($solicitud){
            $soc = (object)['nombre' => null, 'apellido' => null];
            $socio = $solicitud->socio;
            $nombre = explode(",", $socio->nombre);
            $soc->nombre = $nombre[0];
            $soc->apellido = $nombre[1];
            $solicitud->socio = $soc;
            return $solicitud;
        });
    }

    public function aprobarSolicitud(Request $request)
    {

        DB::transaction(function () use ($request){

            //  TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
            $elem = $request->all();
            $sol = $this->solService->modificarSolicitud($elem);
            $sol->socio()->restore();
            if($sol->socio->cuotasSociales->count() == 0)
            {
                GeneradorCuotas::generarCuotaSocial($sol->socio->organismo->cuotas->first()->valor, $sol->socio->id);
            }

            $socioPosta = $sol->socio;
            $fecha_ingreso = Carbon::today()->toDateString();
            $socioPosta->fecha_ingreso = $fecha_ingreso;
            $socioPosta->save();


            $ventaService = new VentasService();

            $venta = [
                'id_asociado' => $sol->id_socio,
                'nro_cuotas' => $sol->cuotas,
                'importe_cuota' => $sol->monto_por_cuota,
                'id_producto' => $sol->id_producto,
                'importe_total' => $sol->cuotas * $sol->monto_por_cuota,
                'importe_otorgado' => $sol->monto_pagado,
                'fecha_vencimiento' => Carbon::today()->addMonths($sol->cuotas + 1)->toDateString(),
                'id_comercializador' => $sol->comercializador
            ];
            $ventaService->crear(
                $sol->id_socio,
                $sol->id_producto,
                null,
                $sol->cuotas,
                $sol->cuotas * $sol->monto_por_cuota,
                1,
                Carbon::today()->addMonths(2)->toDateString(),
                $sol->monto_por_cuota,
                $sol->monto_pagado,
                $sol->comercializador
            );
        });
    }


    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
