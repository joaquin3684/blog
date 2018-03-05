<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolicitudesPendientesDeCobro extends Controller
{
    public function index()
    {
        return view('solicitudesPendientesDeCobro');
    }
}
