<?php   namespace App\Repositories\Eloquent\Repos\Gateway;

use App\Proovedores;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class ProveedoresGateway extends Gateway
{
    function model()
    {
        return 'App\Proovedores';
    }

    public function findSolicitudesByAgenteFinanciero($id)
    {
        return Proovedores::with('solicitudes.socio', 'solicitudes.producto')->where('usuario', $id)->first();
    }

    public function findProductos($id_proveedor)
    {
        return Proovedores::with('productos')->find($id_proveedor);
    }
}