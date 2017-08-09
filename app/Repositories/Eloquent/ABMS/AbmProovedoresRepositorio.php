<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:50
 */

namespace App\Repositories\Eloquent\ABMS;
use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\ABMS\RepositorioAbm;

class AbmProovedoresRepositorio extends RepositorioAbm
{
    function model()
    {
        return 'App\Proovedores';
    }
}