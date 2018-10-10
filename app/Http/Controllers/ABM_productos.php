<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionABMProductos;
use App\PorcentajeColocacion;
use App\Productos;
use App\Services\ABM_ProductosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Eloquent\Repos\Gateway\ProductosGateway as Producto;

class ABM_productos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $producto;
    private $service;
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
        $this->service = new ABM_ProductosService();
    }

    public function index()
    {

        $registros = $this->producto->allWithRelationship();
        return view('ABM_productos', compact('registros'));
    }

    public function traerElementos()
    {
        return $this->producto->all()->map(function($producto) {
            $producto->razon_social = $producto->proovedor->razon_social;
            return $producto;
        });
    }

    public function store(ValidacionABMProductos $request)
    {
        DB::transaction(function() use($request){

           $this->service->crearProducto($request->all());
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Productos::with('porcentajes')->find($id);
    }


    public function update(ValidacionABMProductos $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            PorcentajeColocacion::where('id_producto', $id)->delete();
            $this->producto->update($request->all(), $id);
            $porcentajes = collect($request['porcentajes']);
            $porcentajes->each(function ($porcentaje) use ($id) {
                $porcentaje['id_producto'] = $id;
                PorcentajeColocacion::create($porcentaje);
            });
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->producto->destroy($id);
        PorcentajeColocacion::where('id_producto', $id)->delete();
    }

    public function traerProductos(Request $request)
    {
        $productos = DB::table('productos')
            ->where('id_proovedor', $request['proovedor'])
            ->where('nombre', 'LIKE', '%'.$request['nombre'].'%')
            ->get();
        return $productos;
    }
}
