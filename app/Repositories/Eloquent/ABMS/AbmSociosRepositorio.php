<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:48
 */

namespace App\Repositories\Eloquent\ABMS;
use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\ABMS\RepositorioAbm;

class AbmSociosRepositorio extends RepositorioAbm
{
    function model()
    {
        return 'App\Socios';
    }
}