<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionSubRubro;
use App\Repositories\Eloquent\Repos\Gateway\SubRubroGateway;
use App\Repositories\Eloquent\Repos\SubRubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_SubRubro extends Controller
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
        $this->gateway = new SubRubroGateway();
        $this->repo = new SubRubro();
    }


    public function index()
    {
        return view('ABM_SubRubros');
    }


    public function store(ValidacionSubRubro $request)
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
        $subrubro = $this->gateway->find($id);
        $subrubro->codigo = substr($subrubro->codigo, 5);
        $subrubro->id_anterior = $subrubro->id_departamento;
        return $subrubro;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionSubRubro $request, $id)
    {
        DB::transaction(function() use ($request, $id){
            $subRubro = $this->repo->traerRelaciones($id);
            $codigoNuevo = $request['codigo'];
            if($subRubro->getCodigo() == $codigoNuevo)
            {
                return $this->gateway->update($request->all(), $id);
            }
            else
            {
                if($subRubro->getAfectaCodigoBase() == 1)
                {
                    $config = ConfigImputaciones::where('codigo_base', 'LIKE', '%'.$subRubro->getCodigo().'%')->get();
                    $config->each(function($conf) use ($codigoNuevo){
                        $codigoViejo = substr($conf->codigo_base, 1);
                        $conf->codigo_base = $codigoNuevo.$codigoViejo;
                    });
                }
                $subRubro->modificarCodigo($request->all(), 0);
            }
        });
    }


    public function all()
    {
        return $this->gateway->all();
    }
}
