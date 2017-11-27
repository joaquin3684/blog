<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionDepartamento;
use App\Repositories\Eloquent\Repos\Departamento;
use App\Repositories\Eloquent\Repos\Gateway\DepartamentoGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Departamento extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $gateway;
    private $repo;

    public function __construct()
    {
        $this->gateway = new DepartamentoGateway();
        $this->repo = new Departamento();
    }


    public function index()
    {
        return view('ABM_Departamentos');
    }


    public function store(ValidacionDepartamento $request)
    {
        return $this->gateway->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dpto = $this->gateway->find($id);
        $dpto->codigo = substr($dpto->codigo, 3);
        $dpto->id_anterior = $dpto->id_moneda;
        return $dpto;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionDepartamento $request, $id)
    {
        DB::transaction(function() use ($request, $id){
            $dpto = $this->repo->traerRelaciones($id);
            $codigoNuevo = $request['codigo'];
            if($dpto->getCodigo() == $codigoNuevo)
            {
                return $this->gateway->update($request->all(), $id);
            }
            else
            {
                if($dpto->getAfectaCodigoBase() == 1)
                {
                    $config = ConfigImputaciones::where('codigo_base', 'LIKE', '%'.$dpto->getCodigo().'%')->get();
                    $config->each(function($conf) use ($codigoNuevo){
                        $codigoViejo = substr($conf->codigo_base, 1);
                        $conf->codigo_base = $codigoNuevo.$codigoViejo;
                        $conf->save();
                    });
                }
                $dpto->modificarCodigo($request->all(), 0);
            }
        });
    }


    public function all()
    {
        return $this->gateway->all();
    }
}
