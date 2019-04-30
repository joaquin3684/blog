<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 14/08/18
 * Time: 14:54
 */

namespace App\Services;


use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Proovedores;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;

class ABM_ProveedorService
{
    private $proveedor, $imputacionService;
    public function __construct()
    {
        $this->proveedor = new ProveedoresGateway();
        $this->imputacionService = new ImputacionService();
    }

    public function crearProveedor($elem)
    {
        $usuario = $elem['usuario'];
        $pass = $elem['password'];
        $email = $elem['email'];
        $user = Sentinel::registerAndActivate(['usuario' => $usuario, 'password' => $pass, 'email' => $email]);
        $role = Sentinel::findRoleByName('proveedor');
        $role->users()->attach($user);
        $elem['usuario'] = $user->id;
        $proveedor = Proovedores::create($elem->toArray());
        $codigo = $this->imputacionService->obtenerCodigoNuevo(3110300);
        $imputacion = $this->imputacionService->crear($codigo, 'Cta '.$elem['razon_social'], 1);
        ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);

    }
}