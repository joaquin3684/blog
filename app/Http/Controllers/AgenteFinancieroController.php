<?php

namespace App\Http\Controllers;

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
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero($usuario->usuario);
        return $agente->solicitudes();
    }

    public function reservarCapital(Request $request)
    {
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $this->solicitudGateway->update($elem, $elem['id']);
    }


    public function otorgarCapital(Request $request)
    {
        $fecha = new Carbon();
        $ventasRepo = new VentasRepo();
        $socioRepo = new SociosRepo();
        $proveedorRepo = new ProveedoresRepo();
        $cuotasRepo = new CuotasRepo();
        //TODO: aca se tiene que ejecutar el proceso para que se refleje en la contabilidad
        $elem = $request->all();
        $sol = $this->solicitudGateway->update($elem, $elem['id']);

        $idOrganismo = $sol->organismo;
        $nombre = $sol->nombre;
        $apellido = $sol->apellido;
        $cuit = $sol->cuit;
        $telefono = $sol->telefono;
        $fecha_nacimiento = $sol->fecha_nacimiento;
        $domicilio = $sol->domicilio;
        $codigo_postal = $sol->codigo_postal;
        $proveedor = $sol->agente_financiero;
        $legajo = $sol->legajo;
        $dni = $sol->dni;
        $localidad = $sol->localidad;
        $cuotas = $sol->cuotas;
        $montoPorCuota = $sol->monto_por_cuota;
        $total = $montoPorCuota * $cuotas;

        $proveedor = $proveedorRepo->findProductos($proveedor);
        $producto = $proveedor->getProductos()->first();

        $col = collect();
        $col->put('id_organismo', $idOrganismo);
        $col->put('nombre', $nombre);
        $col->put('apellido', $apellido);
        $col->put('cuit', $cuit);
        $col->put('domicilio', $domicilio);
        $col->put('codigo_postal', $codigo_postal);
        $col->put('fecha_nacimiento', $fecha_nacimiento);
        $col->put('dni', $dni);
        $col->put('fecha_ingreso', $fecha->today()->toDateString());
        $col->put('localidad', $localidad);
        $col->put('telefono', $telefono);
        $col->put('legajo', $legajo);

        $socio = $socioRepo->create($col->toArray());
        $fechaVto = new Carbon();
        $fechaInicio = new Carbon();
        $fechaInicioDeVto = $fechaVto->today()->addMonths(2);

        $venta = $ventasRepo->create([
                            'id_asociado' => $socio->getId(),
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

}
