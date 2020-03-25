<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Imputacion;
use App\Productos;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Services\ABM_ProveedorService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMproovedores;
use App\Http\Requests\ValidacionAltaProveedor;
use Illuminate\Support\Facades\DB;
//use Yajra\Datatables\Facades\Datatables;
use App\Proovedores;
class ABM_proovedores extends Controller
{

    private $service;
    public function __construct()
    {
        $this->service = new ABM_ProveedorService();
    }


    public function index()
  {
      $registros = Proovedores::all();
      return view('ABM_proovedores', compact('registros'));

  }

   public function store(ValidacionAltaProveedor $request)
    {
        $elem = collect($request->all());
        DB::transaction(function () use ($elem) {
        $this->service->crearProveedor($elem);

        });
    }

    public function traerElementos()
    {
        $proveedores =  Proovedores::with('usuario')->get();
        return $proveedores->map(function($item,$key){
            $item = collect($item);
            $item['email'] = $item['usuario']['email'];
            $item['usuario'] = $item['usuario']['usuario'];
            return $item;
        });
    }

    public function show($id)
    {
        $registro = Proovedores::with('usuario')->find($id);
        $arr = $registro->toArray();
        $arr['email'] = $arr['usuario']['email'];
        $arr['usuario'] = $arr['usuario']['usuario'];
        return $arr;
       
    }

    public function update(ValidacionABMproovedores $request, $id)
    {
        $registro = Proovedores::with('usuario')->find($id);
        unset($request['usuario']);
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
