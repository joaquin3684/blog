<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use Illuminate\Http\Request;

class AsientosController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $gateway;

    public function __construct()
    {
        $this->gateway = new AsientosGateway();
    }


    public function index()
    {
        return view('asientosManuales');
    }

    public function store(Request $request)
    {
        DB::transaction(function() use ($request){
            foreach($request['asientos'] as $elem){
                $this->gateway->create($elem);
            }
        });
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



    public function all()
    {
        return $this->gateway->all();
    }
}