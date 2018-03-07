<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use Illuminate\Http\Request;

class CuentaCorrienteComercializador extends Controller
{
   public function index()
    {
        return view('cuentaCorrienteComercializador');
    }

    public function __construct(ComercializadorRepo $repo)
    {
        $this->repo = $repo;
    }

    public function comercializadores()
    {
        return $this->repo->comercializadoresConSolicitudesTerminadas();
    }

    public function solicitudesTerminadasComer($id)
    {
        return $this->repo->solicitudesTerminadasComer($id);
    }
}
