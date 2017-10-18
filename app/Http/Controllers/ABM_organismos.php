<?php

namespace App\Http\Controllers;

use App\CategoriaCuotaSocial;
use App\Organismos;
use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMorganismos;
use App\Repositories\Eloquent\Repos\Gateway\OrganismosGateway as Organismo;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Compilers\BladeCompiler;

class ABM_organismos extends Controller
{

    private $organismo;
    public function __construct(Organismo $organismo)
    {
        $this->organismo = $organismo;
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
            $organismo = $this->organismo->create($request->all());
            $id_organismo = $organismo->id;
            $cuotasSociales = collect($request['cuota_social']);
            $cuotasSociales->each(function ($cuota) use ($id_organismo) {
                $cuota['id_organismo'] = $id_organismo;
                CategoriaCuotaSocial::create($cuota);
            });
        });

    }

    public function show($id)
    {
        return Organismos::with('cuotas')->find($id);
       
    }

    public function update(ValidacionABMorganismos $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            CategoriaCuotaSocial::where('id_organismo', $id)->delete();
            $this->organismo->update($request->all(), $id);
            $cuotasSociales = collect($request['cuota_social']);
            $cuotasSociales->each(function ($cuota) use ($id) {
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
        return  $this->organismo->all();
    }

}
