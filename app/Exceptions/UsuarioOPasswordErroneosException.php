<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/09/17
 * Time: 19:02
 */

namespace App\Exceptions;


class UsuarioOPasswordErroneosException extends MiExceptionClass
{

    protected $status = '404';

    public function __construct()
    {
        $message = $this->build(func_get_args());

        parent::__construct($message);
    }
}