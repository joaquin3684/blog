<?php

namespace App\Http\Controllers;

use App\Chequera;
use Illuminate\Http\Request;

class ChequeraController extends Controller
{

    public function store(Request $request)
    {
        Chequera::create($request->all());
    }


    public function all(Request $request)
    {
        return Chequera::where('id_banco',$request['id_banco'])->get();
    }
}
