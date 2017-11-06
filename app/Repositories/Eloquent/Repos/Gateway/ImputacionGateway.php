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

    public static function traerBancos()
    {
        return DB::table('imputaciones')->where('codigo', 'LIKE', '%'.'1110102'.'%')->get();
    }

    public static function traerDeudores()
    {
        return DB::table('imputaciones')->where('codigo', 'LIKE', '%'.'1310100'.'%')->get();
    }

    public static function buscarPorNombre($nombre)
    {
        return DB::table('imputaciones')->where('nombre', $nombre)->first();
    }

    public static function buscarPorAproximadoNombre($aproximado)
    {
        return DB::table('imputaciones')->where('codigo', 'LIKE', '%'.$aproximado.'%')->get();
    }

    public static function buscarPorCodigo($codigo)
    {
        return DB::table('imputaciones')->where('codigo', $codigo)->first();
    }
}