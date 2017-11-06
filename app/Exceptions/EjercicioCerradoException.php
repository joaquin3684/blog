<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/11/17
 * Time: 12:08
 */

namespace App\Exceptions;


class EjercicioCerradoException extends MiExceptionClass
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