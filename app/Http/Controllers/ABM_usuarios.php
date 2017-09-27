<?php

namespace App\Http\Controllers;

use App\Exceptions\NoSePuedeModificarElUsuarioException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class ABM_usuarios extends Controller
{
    public function index()
  {
  
    return view('ABM_usuarios');
  }

   public function store(Request $request)
    {   
        $user = Sentinel::registerAndActivate($request->all());
        for($i = 0; $request['numeroDeRoles'] > $i; $i++)
        {
            $role = Sentinel::findRoleByName($request['roles'.$i]);
            $role->users()->attach($user);
        } 
        return ['created' => true];
    }

    public function show($id)
    {
        return Sentinel::findById($id);
    }

    public function all()
    {
        return Sentinel::getUserRepository()->get();
    }

    public function update($request, $id)
    {
        $user = Sentinel::findById($id);
        if(Sentinel::validForUpdate($user, $request->all()))
        {
            return Sentinel::update($user, $request->all());
        } else {
            throw new NoSePuedeModificarElUsuarioException('modificacion_incorrecta');
        }

    }


    public function destroy($id)
    {
        $user = Sentinel::findById($id);
        $user->delete();
    }
}
