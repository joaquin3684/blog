<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/09/17
 * Time: 15:24
 */

namespace App\Exceptions;


class NoSePuedeModificarElUsuarioException extends MiExceptionClass
{
    protected $status = '404';

    public function __construct()
    {
        $message = $this->build(func_get_args());

        parent::__construct($message);
    }
}