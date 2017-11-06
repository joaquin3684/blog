<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Notifications\SolicitudAsignada;
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
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesPendientesMutualController extends Controller
{
    private $solicitudesGateway;
    public function __construct()
    {
        $this->solicitudesGateway = new SolicitudGateway();
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
                $col->put('agente_financiero', $agente);

            }

            $sol = $this->solicitudesGateway->update($col->toArray(), $elem['id']);
            $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Agente Financiero Asignado' : 'Procesando Solicitud';
            $sol->save();
            if($sol->agente_financiero != null && $request->has('agente_financiero'))
            {
                $agenteRepo = new ProveedoresGateway();
                $agente = $elem['agente_financiero'];
                $ag = $agenteRepo->find($agente);
                $usuario = Sentinel::findById($ag->usuario);
                $usuario->notify(new SolicitudAsignada($sol));
            }

        });
    }

    public function solicitudes()
    {
        return $this->solicitudesGateway->solicitudesSinAsignar();
    }

    public function proveedores(Request $request)
    {
        return SolicitudesSinInversionistaGateway::proveedores($request['id']);
    }

    public function solicitudesAVerificar()
    {
        return $this->solicitudesGateway->solicitudesConCapitalOtorgado();
    }

    public function aprobarSolicitud(Request $request)
    {

        DB::transaction(function () use ($request){

            //  TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
            $elem = $request->all();
            $sol = $this->solicitudesGateway->update($elem, $elem['id']);
            $proveedorRepo = new ProveedoresRepo();
            $sol->socio()->restore();
            if($sol->socio->cuotasSociales->count() == 0)
            {
                GeneradorCuotas::generarCuotaSocial($sol->socio->organismo->cuota_social, $sol->socio->id);
            }

            $socioPosta = $sol->socio;
            $fecha_ingreso = Carbon::today()->toDateString();
            $socioPosta->fecha_ingreso = $fecha_ingreso;
            $socioPosta->save();

            $socio = $sol->id_socio;
            $cuotas = $sol->cuotas;
            $montoPorCuota = $sol->monto_por_cuota;
            $proveedor = $sol->agente_financiero;
            $proveedor = $proveedorRepo->findProductos($proveedor);
            $producto = $proveedor->getProductos()->first();

            GeneradorVenta::generarVenta($socio, $producto, $cuotas, $montoPorCuota);
        });
    }


    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
