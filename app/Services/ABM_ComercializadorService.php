<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 14/08/18
 * Time: 12:36
 */

namespace App\Services;
use App\Comercializador;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;

class ABM_ComercializadorService
{

    private $imputacionService;
    public function __construct()
    {
        $this->imputacionService = new ImputacionService();
    }

    public function crearComer($elem)
    {
        $pass = $elem['password'];
        $email = $elem['email'];
        $user = Sentinel::registerAndActivate(['password' => $pass, 'email' => $email]);

        //Agrego el username=email al users
        $usuario = User::find($user->id);
        $usuario->usuario = $elem['email'];
        $usuario->save();

        $elem['usuario'] = $user->id;
        $comer = Comercializador::create($elem);
        $role = Sentinel::findRoleByName('comercializador');
        $role->users()->attach($user);
        $codigo = $this->imputacionService->obtenerCodigoNuevo(3110200);
        $imputacion = $this->imputacionService->crear($codigo,'Comisiones a pagar '.$elem['nombre'].' '.$elem['apellido'], 1);
        return $comer;

    }
}