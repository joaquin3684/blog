<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function unirColecciones($array1, $array2, $parametrosComparativo, $parametrosNulos = null)
    {
        $unido =  $array1->map(function ($item) use ($array2, $parametrosComparativo, $parametrosNulos){
            $var = $array2->first(function ($item2) use ($item, $parametrosComparativo){
                foreach ($parametrosComparativo as $parametro){
                    if($item->$parametro != $item2->$parametro){
                        return false;
                    }
                }
                return true;
            });
            $item = collect($item);
            if($var == null)
            {
                return $item->union($parametrosNulos);
            }
            return $item->union($var);
        });
        return $unido;

    }


}
