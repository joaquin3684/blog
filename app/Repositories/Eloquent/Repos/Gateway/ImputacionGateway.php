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
        $imputacion =  DB::table('imputaciones')->where('codigo', 'LIKE', '%'.$codigoBase.'%')->orderBy('codigo', 'desc')->first();
        return $imputacion->codigo + 1;
    }
}