<?php

namespace App\Http\Controllers;

use App\Comercializador;
use App\Http\Requests\ValidacionABMcomercializador;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Services\ABM_ComercializadorService;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Comercializador extends Controller
{
    private $comercializador;
    private $service;
    public function __construct(ComercializadorGateway $comercializador, ABM_ComercializadorService $service)
    {
        $this->comercializador = $comercializador;
        $this->service = $service;
    }

    public function index()
    {
        return view('ABM_comercializadores');
    }


    public function store(ValidacionABMcomercializador $request)
    {
        DB::transaction(function() use ($request){

        $this->service->crearComer($request->all());

        });

    }


    public function show($id)
    {
        return Comercializador::with('usuario')->find($id);
    }

    public function update(ValidacionABMcomercializador $request, $id)
    {
        DB::transaction(function() use ($request, $id){

            $comer = $this->comercializador->find($id);
            $user = Sentinel::findById($comer->usuario);
            $user->update($request->all());
            $request['usuario'] = $user->id;
            $this->comercializador->update($request->all(), $id);

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
        $this->comercializador->destroy($id);
    }

    public function comercializadores()
    {
        return $this->comercializador->all();
    }
}
