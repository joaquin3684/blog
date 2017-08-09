<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

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
        $registro = Proovedores::find($id);
        return $registro;
       
    }



    public function update(ValidacionABMproovedores $request, $id)
    {
        $registro = Proovedores::find($id);
        $registro->fill($request->all())->save();
        return ['updated' => true];
    }


    public function destroy($id)
    {
        $registro = Proovedores::find($id);
        $registro->delete();
        return ['deleted' => true];
    }
}
