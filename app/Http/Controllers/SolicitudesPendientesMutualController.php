<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudesSinInversionistaGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Carbon\Carbon;
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
        $elem = $request->all();
        $col = collect();
        if($request->has('doc_endeudamiento'))
        {
            $endeudamiento = $elem['doc_endeudamiento'];
            $col->put('doc_endeudamiento', $endeudamiento);

        }
        if ($request->has('agente_financiero'))
        {
            $agente = $elem['agente_financiero'];
            $col->put('agente_financiero', $agente);
        }

        $sol = $this->solicitudesGateway->update($col->toArray(), $elem['id']);
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Agente Financiero Asignado' : 'Procesando Solicitud';
        $sol->save();
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
            $fecha_ingreso = Carbon::today()->toDateString();
            $ventasRepo = new VentasRepo();
            $socioRepo = new SociosRepo();
            $proveedorRepo = new ProveedoresRepo();
            $cuotasRepo = new CuotasRepo();
            //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
            $elem = $request->all();
            $sol = $this->solicitudesGateway->update($elem, $elem['id']);

            $sol->socio()->restore();
            $socioPosta = $sol->socio;
            $socioPosta->fecha_ingreso = $fecha_ingreso;
            $socioPosta->save();

            $socio = $sol->id_socio;
            $cuotas = $sol->cuotas;
            $montoPorCuota = $sol->monto_por_cuota;
            $total = $montoPorCuota * $cuotas;
            $proveedor = $sol->agente_financiero;
            $proveedor = $proveedorRepo->findProductos($proveedor);
            $producto = $proveedor->getProductos()->first();

            $fechaVto = new Carbon();
            $fechaInicio = new Carbon();
            $fechaInicioDeVto = $fechaVto->today()->addMonths(2);
            $venta = $ventasRepo->create([
                'id_asociado' => $socio,
                'id_producto' => $producto->getId(),
                'nro_cuotas' => $cuotas,
                'importe' => $total,
                'fecha_vencimiento' => $fechaInicioDeVto->toDateString(),
            ]);
            $fechaInicio->today();
            $cuotasRepo->create([
                'cuotable_id' => $venta->getId(),
                'cuotable_type' => 'App\Ventas',
                'importe' => $montoPorCuota,
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_vencimiento' => $fechaInicioDeVto->toDateString(),
                'nro_cuota' => '1',
            ]);
            $fechaInicio->addMonths(2);
            for ($i = 2; $i <= $cuotas; $i++) {
                $fechaInicioDeVto = $fechaInicioDeVto->addMonth();
                $cuotasRepo->create([
                    'cuotable_id' => $venta->getId(),
                    'cuotable_type' => 'App\Ventas',
                    'importe' => $montoPorCuota,
                    'fecha_inicio' => $fechaInicio->toDateString(),
                    'fecha_vencimiento' => $fechaInicioDeVto->toDateString(),
                    'nro_cuota' => $i,
                ]);
                $fechaInicio = $fechaInicio->addMonth();
            }
        });
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
