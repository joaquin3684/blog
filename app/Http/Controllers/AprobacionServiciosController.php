<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AprobacionServiciosController extends Controller
{
    public function index()
    {
        return view('aprobacion_servicios');
    }

    public function datos()
    {
        return $ventas = Ventas::with('estados', 'cuotas', 'producto.proovedor', 'socio')->whereDoesntHave('estados', function($q){
            $q->where('estado', '=', 'APROBADO');
            $q->orWhere('estado', '=', 'RECHAZADO');
        })->get();
    }

    public function aprobarServicios(Request $request)
    {
        DB::transaction(function() use ($request){

            $user = Sentinel::getUser()->id;
            foreach ($request->all() as $servicio)
            {

                $id = $servicio['id'];
                $estado = $servicio['estado'];
                $estadoRepo = new EstadoVentaRepo();
                $data = array('id_venta' => $id, 'id_responsable_estado' => $user, 'estado' => $estado);
                $estadoRepo->create($data);
                $ventasRepo = new VentasRepo();
                $venta = $ventasRepo->find($id);
                if($estado == 'APROBADO')
                {
                    GeneradorCuotas::generarCuotasVenta($venta);


                }
                if($estado == 'RECHAZADO')
                {
                    $ventasRepo->destroy($id);
                }


            }
        });
    }
}
