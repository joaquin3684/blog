<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudesSinInversionistaGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use Illuminate\Http\Request;

class SolicitudesPendientesMutualController extends Controller
{
    private $solicitudesGateway;
    public function __construct()
    {
        $this->solicitudesGateway = new SolicitudesSinInversionistaGateway();
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
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Inversionista Asignado' : 'Procesando Solicitud';
        $sol->save();
    }

    public function solicitudes()
    {
        return $this->solicitudesGateway->solicitudesSinAsignar();
    }

    public function fotos(Request $request)
    {
        $id = $request['id'];
        return FileManager::buscarImagenesSolicitud($id);
    }

}
