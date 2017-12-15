<?php namespace App\Repositories\Eloquent\Repos;
use App\Proovedores;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Mapper\ProveedoresMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:04
 */
class ProveedoresRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new ProveedoresMapper();
        $this->gateway = new ProveedoresGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\ProveedoresRepo';
    }

    public function findProductos($id_proveedor)
    {
        $proveedor = $this->gateway->findProductos($id_proveedor);
        return $this->mapper->map($proveedor);
    }

    public function getProveedorConCuotasSinContabilizar($id)
    {
         $proveedor = Proovedores::with(['productos.ventas.cuotas.movimientos' => function($q){
            $q->where('movimientos.contabilizado_salida', '0')
            ->whereRaw('movimientos.entrada = movimientos.salida');
        }])->find($id);
         return $this->mapper->map($proveedor);
    }
}