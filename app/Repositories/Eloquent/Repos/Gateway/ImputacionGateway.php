<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


use Illuminate\Support\Facades\DB;

class ImputacionGateway extends Gateway
{
    function model()
    {
        return 'App\Imputacion';
    }

    public static function obtenerCodigoNuevo($codigoBase)
    {
        return DB::table('imputaciones')->where('codigo', 'like', '%'.$codigoBase.'%')->orderBy('codigo', 'desc')->first()->codigo;
    }
}