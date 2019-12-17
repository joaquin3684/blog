<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/08/17
 * Time: 16:55
 */

namespace App\Exceptions;        $socio->getCuotasSociales()->each(function($cuota) use (&$monto){

use App\Traits\Conversion;


class MasPlataCobradaQueElTotalException extends MiExceptionClass
{
    /**
     * @var string
     */
    protected $status = '404';
    /**
     * @return void
     */
    public function __construct()
    {
        $message = $this->build(func_get_args());

        parent::__construct($message);
    }


}