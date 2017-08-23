<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMproovedores;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use App\Proovedores;
class ABM_proovedores extends Controller
{
    
  public function index()
  {
      $registros = Proovedores::all();
      return view('ABM_proovedores', compact('registros'));

  }

   public function store(ValidacionABMproovedores $request)
    {
        $elem = collect($request->all());
        DB::transaction(function () use ($elem) {
        $usuario = $elem['usuario'];
        $pass = $elem['password'];
        $email = $elem['email'];

            $user = Sentinel::registerAndActivate(['usuario' => $usuario, 'password' => $pass, 'email' => $email]);
            $elem['usuario'] = $user->id;
            Proovedores::create($elem->toArray());

        });
    }

    public function traerElementos()
    {
        return Proovedores::all();
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

    public function datos()
    {
        return Datatables::eloquent(Proovedores::query())->make(true);
    }

    public function traerRelacion()
    {
        return Proovedores::all();
    }
}
