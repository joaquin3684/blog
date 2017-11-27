<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Imputacion;
use App\Productos;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
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
            $proveedor = Proovedores::create($elem->toArray());
            $codigoBase = ConfigImputaciones::find(1);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Deudores '.$elem['razon_social'], $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);
            $codigoBase = ConfigImputaciones::find(2);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Cta '.$elem['razon_social'], $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Cta', 'codigo' => $imputacion->codigo]);
            $codigoBase = ConfigImputaciones::find(3);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Comisiones '.$elem['razon_social'], $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Comisiones', 'codigo' => $imputacion->codigo]);


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
        return Proovedores::all()->map(function($proveedor){
            $p = collect($proveedor);
            $p->put('nombre', $proveedor->razon_social);
            return $p;
        });
    }

    public function productos(Request $request)
    {
        return Productos::where('id_proovedor', $request['id'])->get();
    }
}
