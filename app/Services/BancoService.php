<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 23/04/19
 * Time: 11:21
 */

namespace App\Services;


use App\Banco;

class BancoService
{
    public function crear($nombre, $sucursal, $direccion, $nro_cuenta)
    {
        return Banco::create(['nombre' => $nombre, 'sucursal' => $sucursal, 'direccion' => $direccion, 'nro_cuenta' => $nro_cuenta]);
    }

    public function find($id)
    {
        return Banco::find($id);
    }

    public function all()
    {
        return Banco::all();
    }

    public function destroy($id)
    {
        Banco::destroy($id);
    }

    public function update($data, $id)
    {
        $banco = Banco::find($id);
        $banco->update($data);
        return $banco;
    }


}