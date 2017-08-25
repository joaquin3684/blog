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
        if(!$solicitud->has('id_socio'))
        {
            $socioRepo = new SociosRepo();
            $socio = $socioRepo->create($solicitud->toArray());
            $solicitud->put('id_socio', $socio->getId());
            $socioRepo->destroy($socio->getId());
        }

        $solicitud->put('estado', 'Procesando Solicitud');
        $solicitud->put('comercializador', $this->id);

        $repoSolicitud = new SolicitudRepo();
        $solicitud =  $repoSolicitud->create($solicitud->toArray());
        $this->addSolicitud($solicitud);

        $repo = new SolicitudesSinInversionistaRepo();

        $agentesFiltrados->each(function($agente) use ($solicitud, $repo){
            $repo->create(['solicitud' => $solicitud->getId(), 'agente_financiero' => $agente->getId()]);
        });


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