<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoProveedorContable extends Controller
{
    public function index()
    {
        return view('pago_contable');
    }

    public function pagar(Request $request)
    {

    }
}
