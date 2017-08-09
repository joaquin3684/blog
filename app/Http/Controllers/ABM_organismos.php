<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMorganismos;
use App\Repositories\Eloquent\Repos\Gateway\OrganismosGateway as Organismo;
use Illuminate\Support\Facades\Blade;
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
        $this->organismo->create($request->all());

    }

    public function show($id)
    {
        return $this->organismo->find($id);
       
    }

    public function update(ValidacionABMorganismos $request, $id)
    {
        $this->organismo->update($request->all(), $id);
    }


    public function destroy($id)
    {
        $this->organismo->destroy($id);
    }

    public function traerRelacionorganismos()
    {
        return  $this->organismo->all();
    }

}
