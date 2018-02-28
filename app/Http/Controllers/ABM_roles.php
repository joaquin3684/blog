<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pantallas;
use Sentinel;

class ABM_roles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ABM_roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Sentinel::getRoleRepository()->createModel()->create($request->all());
        $permisos = array();
       
       
        for($i = 0;  $i < $request['numeroDePantallas']; $i++)
        {
            for($j = 0; $j < count($request['valor'.$i]); $j++)
            {
                $index = $request['pantalla'.$i].'.'.$request['valor'.$i][$j];
                $permisos[$index] = true;
                
            }
           
        }
        $role->permissions = $permisos;
        $role->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function all()
    {
        $roles = Sentinel::getRoleRepository()->get();
        return $roles;
    }

    public function traerRelacionpantallas()
    {

        $pantallas = Pantallas::all();
        $pantallasUnicas = $pantallas->unique('nombre');
        return $pantallasUnicas;
    }
    public function traerRoles()
    {
        $roles = Sentinel::getRoleRepository()->get();
        return $roles;
    }
}
