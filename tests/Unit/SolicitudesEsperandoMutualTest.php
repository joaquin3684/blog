<?php

namespace Tests\Unit;

use App\Cuotas;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Generadores\GeneradorVenta;
use App\Repositories\Eloquent\GeneradorNumeroCredito;
use App\Repositories\Eloquent\Cuota;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\ProveedoresRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use App\Socios;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SolicitudesEsperandoMutualTest extends TestCase
{
    use DatabaseTransactions;

    private $solicitudGateway;
    private $solCreada;
    public function setUp()
    {
        parent::setUp();
        $this->solicitudGateway = new SolicitudGateway();
        $data = $this->getData();
        $this->solCreada = $this->solicitudGateway->create($data->toArray());
    }


    // TODO:: hay que testear que cuando aprobas la solicitud de un socio que nunca fue socio cree la cuota social y vicebersa
    public function getData()
    {
        return collect([
            'id_socio' => 1,
            'comercializador' => '1',
            'estado' => 'Procesando Solicitud',
            'monto_por_cuota' => '200',
            'total' => '500',
            'cuotas' => '2',
            'agente_financiero' => 11,
        ]);
    }

    public function testEsperandoEndeudamientoYAgenteYcompletoUno()
    {
        $elem = collect();
        $col = collect();
        if($elem->has('doc_endeudamiento'))
        {
            $endeudamiento = $elem['doc_endeudamiento'];
            $col->put('doc_endeudamiento', $endeudamiento);

        }
        if ($elem->has('agente_financiero'))
        {
            $agente = $elem['agente_financiero'];
            $col->put('agente_financiero', $agente);
        }

        $sol = $this->solicitudGateway->update($col->toArray(), $this->solCreada->id);
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Agente Financiero Asignado' : 'Procesando Solicitud';
        $sol->save();
        $this->assertEquals($sol->doc_endeudamiento, null);
        $this->assertEquals($sol->agente_financiero, 11);
        $this->assertEquals($sol->estado, 'Procesando Solicitud');
    }

    public function testEsperandoEndeudamientoYAgenteYcompletoAmbos()
    {
        $elem = collect(['doc_endeudamiento' => '200', 'agente_financiero' => 1]);
        $col = collect();
        if($elem->has('doc_endeudamiento'))
        {
            $endeudamiento = $elem['doc_endeudamiento'];
            $col->put('doc_endeudamiento', $endeudamiento);

        }
        if ($elem->has('agente_financiero'))
        {
            $agente = $elem['agente_financiero'];
            $col->put('agente_financiero', $agente);
        }

        $sol = $this->solicitudGateway->update($col->toArray(), $this->solCreada->id);
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Inversionista Asignado' : 'Procesando Solicitud';
        $sol->save();
        $this->assertEquals($sol->estado, 'Inversionista Asignado');
        $this->assertEquals($sol->doc_endeudamiento, 200);
        $this->assertEquals($sol->agente_financiero, 1);
    }

    public function testAprobarSolicitud()
    {
        $fecha_ingreso = Carbon::today()->toDateString();

        $proveedorRepo = new ProveedoresRepo();

        $sol = $this->solicitudGateway->update(['estado' => 'Solicitud Aprobada'], $this->solCreada->id);

        $sol->socio()->restore();
        if($sol->socio->cuotasSociales->count() == 0)
        {
            GeneradorCuotas::generarCuotaSocial($sol->socio->organismo->cuota_social, $sol->socio->id);
        }

        $socioPosta = $sol->socio;
        $socioPosta->fecha_ingreso = $fecha_ingreso;
        $socioPosta->save();

        $socio = $sol->id_socio;
        $cuotas = $sol->cuotas;
        $montoPorCuota = $sol->monto_por_cuota;
        $proveedor = $sol->agente_financiero;
        $proveedor = $proveedorRepo->findProductos($proveedor);
        $producto = $proveedor->getProductos()->first();

        $ventaActual = GeneradorVenta::generarVenta($socio, $producto, $cuotas, $montoPorCuota);
        $ventasMapper = new VentasMapper();
        $ventaExpected = $ventasMapper->map(Ventas::with('cuotas')->find($ventaActual->getId()));
        $this->assertEquals($ventaExpected, $ventaActual);
        $this->assertEquals($sol->socio->deleted_at, null);
        $this->assertEquals($sol->estado, 'Solicitud Aprobada');
        $this->assertEquals(Socios::with('cuotasSociales')->find($socioPosta->id)->cuotasSociales->count(), 1);
    }




}
