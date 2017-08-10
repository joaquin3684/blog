<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/08/17
 * Time: 10:25
 */

namespace App\Traits;


trait FechasManager
{
    private $carbon;

    public function __construct()
    {
        $this->carbon = new Carbon();

    }

    public function getFechaHoy()
    {
        return $this->carbon->today()->toDateString();
    }
}