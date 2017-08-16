<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 18:37
 */

namespace App\Repositories\Eloquent;


use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\SolicitudesSinInversionistaRepo;
use App\Repositories\Eloquent\Repos\SolicitudRepo;

class Comercializador
{
    private $solicitudes;
    private $id;

    public function __construct($id, $solicitudes = null)
    {
        $this->id = $id;
        $this->solicitudes = $this->solicitudes == null ? collect() : $solicitudes;
    }

    public function generarSolicitud($solicitud, $agentesFiltrados)
    {
        $designador = new DesignarAgenteFinanciero($agentesFiltrados);
        $agente = $designador->elegirAgente() == null ? null : $designador->elegirAgente()->getId();
        $designarEstado = new DesignadorDeEstado($solicitud);
        $estado = $designarEstado->buscarEstado($agente);

        if($solicitud->has('id_socio'))
        {
            $socioRepo = new SociosRepo();
            $solicitud->put('pertenece', 0);
            $socio = $socioRepo->create($solicitud->toArray());
            $solicitud->put('id_socio', $socio->getId());
            $socioRepo->destroy($socio->getId());
        }


        $solicitud->put('agente_financiero', $agente);
        $solicitud->put('estado', $estado);
        $solicitud->put('comercializador', $this->id);

        $repoSolicitud = new SolicitudRepo();
        $solicitud =  $repoSolicitud->create($solicitud->toArray());
        $this->addSolicitud($solicitud);

        $repo = new SolicitudesSinInversionistaRepo();
        if($estado == 'Procesando Solicitud'){
            $agentesFiltrados->each(function($agente) use ($solicitud, $repo){
                $repo->create(['solicitud' => $solicitud->getId(), 'agente_financiero' => $agente->getId()]);
            });
        }

        return $solicitud;


    }

    public function addSolicitud($solicitud)
    {
        $this->solicitudes->push($solicitud);
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

    /**
     * @param \Illuminate\Support\Collection|null $solicitudes
     */
    public function setSolicitudes($solicitudes)
    {
        $this->solicitudes = $solicitudes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}