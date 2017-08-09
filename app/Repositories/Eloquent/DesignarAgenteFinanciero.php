<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/07/17
 * Time: 18:02
 */

namespace App\Repositories\Eloquent;


class DesignarAgenteFinanciero
{
    private $agentes;

    /**
     * DesignarAgenteFinanciero constructor.
     * @param $agentes
     */
    public function __construct($agentes)
    {
        $this->agentes = $agentes;
    }

    public function elegirAgente()
    {
        if($this->agentes->count() == 1)
        {
            return $this->agentes->first();


        } else if ($this->agentes->count() > 1)
        {
            return null;
        }
    }


}