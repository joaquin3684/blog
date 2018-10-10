<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 14/08/18
 * Time: 11:16
 */

namespace App\Services;
use App\CategoriaCuotaSocial;
use App\Repositories\Eloquent\Repos\Gateway\OrganismosGateway as Organismo;


class ABM_OrganismosService
{
    private $organismo;
    public function __construct()
    {
        $this->organismo = new Organismo();
    }
    public function crearOrganismo($elem)
    {
        $organismo = $this->organismo->create($elem);
        $id_organismo = $organismo->id;
        $cuotasSociales = collect($elem['cuota_social']);
        $i = 0;
        $cuotasSociales->each(function ($cuota) use ($id_organismo, &$i) {
            $cuota['id_organismo'] = $id_organismo;
            $cuota['categoria'] = $i;
            CategoriaCuotaSocial::create($cuota);
            $i++;
        });
    }
}