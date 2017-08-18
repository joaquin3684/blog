<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Traits\FechasManager;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;


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

    public function accionesSobrePropuesta(Request $request)
    {
        //este metodo ataja todas las acciones de la propeusta y sus cambios de estado

        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
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
        $this->solicitudGateway->update($elem, $elem['id']);
    }


    public function otorgarCapital(Request $request)
    {
        $fecha_ingreso = Carbon::today()->toDateString();
        $ventasRepo = new VentasRepo();
        $socioRepo = new SociosRepo();
        $proveedorRepo = new ProveedoresRepo();
        $cuotasRepo = new CuotasRepo();
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $sol = $this->solicitudGateway->update($elem, $elem['id']);

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
                            'nro_cuotas'  => $cuotas,
                            'importe'     => $total,
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
        for ($i=2; $i <= $cuotas; $i++)
        {
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
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
