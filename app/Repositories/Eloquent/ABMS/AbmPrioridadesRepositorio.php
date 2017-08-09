<?php

namespace App\Repositories\Eloquent\ABMS;
use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\ABMS\RepositorioAbm;

class AbmPrioridadesRepositorio extends RepositorioAbm
{
    function model()
    {
        return 'App\Prioridades';
    }
}