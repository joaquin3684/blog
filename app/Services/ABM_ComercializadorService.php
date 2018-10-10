<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 14/08/18
 * Time: 12:36
 */

namespace App\Services;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;

class ABM_ComercializadorService
{
    public function __construct()
    {
        $this->comercializador = new ComercializadorGateway();
    }

    public function crearComer($elem)
    {
        $usuario = $elem['usuario'];
        $pass = $elem['password'];
        $email = $elem['email'];
        $user = Sentinel::registerAndActivate(['usuario' => $usuario, 'password' => $pass, 'email' => $email]);
        $elem['usuario'] = $user->id;
        $this->comercializador->create($elem);
        $role = Sentinel::findRoleByName('comercializador');
        $role->users()->attach($user);
        $codigo = ImputacionGateway::obtenerCodigoNuevo(3110200);
        $imputacion = GeneradorDeCuentas::generar('Comisiones a pagar '.$elem['nombre'].' '.$elem['apellido'], $codigo);

    }
}