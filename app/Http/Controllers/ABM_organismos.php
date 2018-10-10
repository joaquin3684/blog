<?php

namespace App\Http\Controllers;

use App\CategoriaCuotaSocial;
use App\Organismos;
use App\Services\ABM_OrganismosService;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMorganismos;
use App\Repositories\Eloquent\Repos\Gateway\OrganismosGateway as Organismo;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Compilers\BladeCompiler;

class ABM_organismos extends Controller
{

    private $organismo;
    private $service;
    public function __construct(Organismo $organismo, ABM_OrganismosService $service)
    {
        $this->organismo = $organismo;
        $this->service = $service;
    }


    public function index()
    {   
        $registros = $this->organismo->all();

        return view('ABM_organismos', compact('registros'));
        
    }

    public function traerElementos()
    {
        return $this->organismo->all();
    }

    public function store(ValidacionABMorganismos $request)
    {
        DB::transaction(function() use($request) {

            $this->service->crearOrganismo($request->all());

        });

    }

    public function show($id)
    {
        return Organismos::with('cuotas')->find($id);
       
    }

    public function update(ValidacionABMorganismos $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            $cuotasSocialesNuevas = collect($request['cuota_social']);
            $organismo = Organismos::with(['socios.cuotasSociales' => function($q){$q->where('estado', null);}, 'cuotas'])->find($id);
            $organismo->cuotas->each(function($cuotaSocialActual) use ($organismo, $cuotasSocialesNuevas){

                $organismo->socios->each(function($socio) use ($cuotaSocialActual, $cuotasSocialesNuevas){
                    $socio->cuotasSociales->each(function($cuota) use ($cuotaSocialActual, $cuotasSocialesNuevas, $socio){
                        if($cuota->importe == $cuotaSocialActual->valor){
                            $cuotaNueva = $cuotasSocialesNuevas->first(function($c) use ($cuotaSocialActual){return $cuotaSocialActual->categoria == $c['categoria'];});
                            $cuota->importe = $cuotaNueva['valor'];
                            $socio->valor = $cuotaNueva['valor'];
                            $cuota->save();
                            $socio->save();
                        } else {return false;}
                    });
                 });
            });

            CategoriaCuotaSocial::where('id_organismo', $id)->delete();
            $this->organismo->update($request->all(), $id);
            $cuotasSocialesNuevas->each(function ($cuota) use ($id) {
                $cuota['id_organismo'] = $id;
                CategoriaCuotaSocial::create($cuota);
            });
        });
    }


    public function destroy($id)
    {
        $this->organismo->destroy($id);
        CategoriaCuotaSocial::where('id_organismo', $id)->delete();

    }

    public function traerRelacionorganismos()
    {
        return  Organismos::with('cuotas')->get();
    }

}
