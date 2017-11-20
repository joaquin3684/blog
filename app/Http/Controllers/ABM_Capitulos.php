<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionCapitulo;
use App\Repositories\Eloquent\Repos\Capitulo;
use App\Repositories\Eloquent\Repos\Gateway\CapituloGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Capitulos extends Controller
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
        $this->gateway = new CapituloGateway();
        $this->repo = new Capitulo();
    }


    public function index()
    {
        return view('ABM_capitulos');
    }


    public function store(ValidacionCapitulo $request)
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
        return $this->gateway->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionCapitulo $request, $id)
    {
        DB::transaction(function() use ($request, $id){
            $capitulo = $this->repo->traerRelaciones($id);
            $codigoNuevo = $request['codigo'];
            if($capitulo->getCodigo() == $codigoNuevo)
            {
                return $this->gateway->update($request->all(), $id);
            }
            else
            {
                if($capitulo->getAfectaCodigoBase() == 1)
                {
                    $config = ConfigImputaciones::where('codigo_base', 'LIKE', '%'.$capitulo->getCodigo().'%')->get();
                    $config->each(function($conf) use ($codigoNuevo){
                        $codigoViejo = substr($conf->codigo_base, 1);
                        $conf->codigo_base = $codigoNuevo.$codigoViejo;
                        $conf->save();
                    });
                }
                $capitulo->modificarCodigo($request->all());
            }
        });
    }


    public function all()
    {
        return $this->gateway->all();
    }
}
