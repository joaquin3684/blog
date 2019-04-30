<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibroDiarioController extends Controller
{
    public function index()
    {
        return view('libro_diario');
    }

    public function reporte(Request $request)
    {

    }
}
