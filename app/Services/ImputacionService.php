<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 17/04/19
 * Time: 22:45
 */

namespace App\Services;


use App\Imputacion;
use Illuminate\Support\Facades\DB;

class ImputacionService
{

    private $saldoService, $subRubroService;
    public function __construct()
    {
        $this->saldoService = new SaldoService();
        $this->subRubroService = new SubRubroService();
    }

    public static function findByCodigo($codigo)
    {
        return DB::table('imputaciones')->where('codigo', $codigo)->first();
    }

    public function find($id)
    {
        return Imputacion::find($id);
    }

    public function obtenerCodigoNuevo($codigoBase)
    {
        $imputacion =  DB::table('imputaciones')->where('codigo', 'LIKE', '%'.$codigoBase.'%')->orderBy('codigo', 'desc')->first();
        if($imputacion == null)
            return $codigoBase.'01';
         else
            return $imputacion->codigo + 1;
    }

    public function crear($codigo, $nombre, $afecta_codigo_base)
    {
        $codigoSubRubro = substr((string) $codigo, 0, -2);
        $subRubro = $this->subRubroService->findByCodigo($codigoSubRubro);
        $imputacion = Imputacion::create(['nombre' => $nombre, 'codigo' => $codigo, 'id_subrubro' => $subRubro->id]);
        $this->saldoService->crear($imputacion, 0, 0);
        return $imputacion;
    }

}