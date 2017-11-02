<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/10/17
 * Time: 20:15
 */

namespace App\Exceptions;


class FechaContableElejidaEnEjercicioCerradoException extends MiExceptionClass
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