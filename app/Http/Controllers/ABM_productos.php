<?php

namespace App\Http\Controllers;

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

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function index()
    {

        $registros = $this->producto->all();
        return view('ABM_productos', compact('registros'));
    }

    public function traerElementos()
    {
        return $this->producto->all();
    }

    public function store(Request $request)
    {
        $this->producto->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->producto->find($id);
    }


    public function update(Request $request, $id)
    {
        $this->producto->update($request->all(), $id);
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
