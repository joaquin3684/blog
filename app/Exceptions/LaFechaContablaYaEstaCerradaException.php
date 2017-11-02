<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/10/17
 * Time: 17:42
 */

namespace App\Exceptions;


class LaFechaContablaYaEstaCerradaException extends MiExceptionClass
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