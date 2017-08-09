<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 18:37
 */

namespace App\Repositories\Eloquent;


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

    public function generarSolicitud($nombre, $apellido, $cuit, $domicilio, $telefono, $codigo_postal, $doc_documento, $doc_recibo, $doc_domicilio, $doc_cbu, $doc_endeudamiento, $agentesFiltrados)
    {

        $designador = new DesignarAgenteFinanciero($agentesFiltrados);

        $agente = $designador->elegirAgente() == null ? null : $designador->elegirAgente()->getId();

        $designarEstado = new DesignadorDeEstado();
        $estado = $designarEstado->buscarEstado($agente);

        $repoSolicitud = new SolicitudRepo();
        $solicitud = $repoSolicitud->create(['nombre' => $nombre,
                                             'apellido' => $apellido,
                                             'cuit' => $cuit,
                                             'domicilio' => $domicilio,
                                             'telefono' => $telefono,
                                             'codigo_postal' => $codigo_postal,
                                             'comercializador' => $this->id,
                                             'doc_documento' => $doc_documento,
                                             'doc_recibo' => $doc_recibo,
                                             'doc_domicilio' => $doc_domicilio,
                                             'doc_cbu' => $doc_cbu,
                                             'doc_endeudamiento' => $doc_endeudamiento,
                                             'agente_financiero' => $agente,
                                             'estado' => $estado]);


        $repo = new SolicitudesSinInversionistaRepo();
        if($agentesFiltrados->count() > 1){
            $agentesFiltrados->each(function($agente) use ($solicitud, $repo){
                $repo->create(['solicitud' => $solicitud->getId(), 'agente_financiero' => $agente->getId()]);

            });
        }


        $this->addSolicitud($solicitud);
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