<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionRubro;
use App\Repositories\Eloquent\Repos\Gateway\RubroGateway;
use App\Repositories\Eloquent\Repos\Rubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Rubros extends Controller
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
        $this->gateway = new RubroGateway();
        $this->repo = new Rubro();
    }


    public function index()
    {
        return view('ABM_rubros');
    }


    public function store(ValidacionRubro $request)
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
        $rubro = $this->gateway->find($id);
        $rubro->codigo = substr($rubro->codigo, 1);
        $rubro->id_anterior = $rubro->id_capitulo;
        return $rubro;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionRubro $request, $id)
    {
        DB::transaction(function() use ($request, $id){
            $rubro = $this->repo->traerRelaciones($id);
            $codigoNuevo = $request['codigo'];
            if($rubro->getCodigo() == $codigoNuevo)
            {
                return $this->gateway->update($request->all(), $id);
            }
            else
            {
                if($rubro->getAfectaCodigoBase() == 1)
                {
                    $config = ConfigImputaciones::where('codigo_base', 'LIKE', '%'.$rubro->getCodigo().'%')->get();
                    $config->each(function($conf) use ($codigoNuevo){
                        $codigoViejo = substr($conf->codigo_base, 1);
                        $conf->codigo_base = $codigoNuevo.$codigoViejo;
                        $conf->save();
                    });
                }
                $rubro->modificarCodigo($request->all(), 0);
            }
        });
    }



    public function all()
    {
        return $this->gateway->all();
    }
}
