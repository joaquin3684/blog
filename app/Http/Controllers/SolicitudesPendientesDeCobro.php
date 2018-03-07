<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\ComercializadorRepo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class SolicitudesPendientesDeCobro extends Controller
{

    private $repo;
    public function __construct(ComercializadorRepo $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        return view('solicitudesPendientesDeCobro');
    }

    public function solicitudes()
    {
        $usuario = Sentinel::check();
        $comer = $this->repo->findByUser($usuario->id);
        return $this->repo->findSolicitudesPendientesDeCobro($comer->getId());


    }
}
