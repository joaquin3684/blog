<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 19/10/17
 * Time: 19:48
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\Asiento;
use Illuminate\Support\Facades\DB;

class AsientosGateway extends Gateway
{
    function model()
    {
        return 'App\Asiento';
    }

    public function last()
    {
        return DB::table('asientos')->orderBy('nro_asiento', 'desc')->first();
    }
}