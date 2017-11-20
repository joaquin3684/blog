<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionMoneda;
use App\Repositories\Eloquent\Repos\Gateway\MonedaGateway;
use App\Repositories\Eloquent\Repos\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Moneda extends Controller
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
        $this->gateway = new MonedaGateway();
        $this->repo = new Moneda();
    }


    public function index()
    {
        return view('ABM_Moneda');
    }


    public function store(ValidacionMoneda $request)
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
        $moneda = $this->gateway->find($id);
        $moneda->codigo = substr($moneda->codigo, 2);
        $moneda->id_anterior = $moneda->id_rubro;
        return $moneda;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionMoneda $request, $id)
    {
        DB::transaction(function() use ($request, $id){
            $moneda = $this->repo->traerRelaciones($id);
            $codigoNuevo = $request['codigo'];
            if($moneda->getCodigo() == $codigoNuevo)
            {
                return $this->gateway->update($request->all(), $id);
            }
            else
            {
                if($moneda->getAfectaCodigoBase() == 1)
                {
                    $config = ConfigImputaciones::where('codigo_base', 'LIKE', '%'.$moneda->getCodigo().'%')->get();
                    $config->each(function($conf) use ($codigoNuevo){
                        $codigoViejo = substr($conf->codigo_base, 1);
                        $conf->codigo_base = $codigoNuevo.$codigoViejo;
                    });
                }
                $moneda->modificarCodigo($request->all(), 0);
            }
        });
    }



    public function all()
    {
        return $this->gateway->all();
    }
}
