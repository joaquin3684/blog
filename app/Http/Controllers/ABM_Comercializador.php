<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionABMcomercializador;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ABM_Comercializador extends Controller
{
    private $comercializador;
    public function __construct(ComercializadorGateway $comercializador)
    {
        $this->comercializador = $comercializador;
    }

    public function index()
    {
        return view('ABM_comercializadores');
    }


    public function store(ValidacionABMcomercializador $request)
    {
        $elem = $request->all();
        $usuario = $elem['usuario'];
        $pass = $elem['password'];
        $email = $elem['email'];
        $user = Sentinel::registerAndActivate(['usuario' => $usuario, 'password' => $pass, 'email' => $email]);
        $elem['usuario'] = $user->id;
        $this->comercializador->create($elem);
        //TODO: aca hay que ponerle el rol de comercializador

        return ['created' => true];
    }


    public function show($id)
    {
        return $this->comercializador->find($id);
    }

    public function update(ValidacionABMcomercializador $request, $id)
    {
        $this->comercializador->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->comercializador->destroy($id);
    }

    public function comercializadores()
    {
        return $this->comercializador->all();
    }
}
