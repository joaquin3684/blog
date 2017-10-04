<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/10/17
 * Time: 09:24
 */

namespace App\Exceptions;


class NotFoundException extends MiExceptionClass
{
    protected $status = '404';

    public function __construct()
    {
        $message = $this->build(func_get_args());

        parent::__construct($message);
    }
}