<?php

namespace App\Http\Controllers;




use App\ControlFechaContable;
use App\Exceptions\LaFechaContablaYaEstaCerradaException;
use App\Exceptions\UsuarioOPasswordErroneosException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Login extends Controller
{
	public function index()
	{
		return view('login');
	}    

	public function login(Request $request)
	{
        DB::transaction(function() use($request){

            Sentinel::authenticate($request->all());
            $user = Sentinel::check();
            if ($user) {
                $fecha = ControlFechaContable::where('id_usuario', $user->id)->first();
                if ($fecha == null) {

                } else {
                    ControlFechaContable::where('id_usuario', $user->id)->delete();
                }
                $registros = [];
                return view('ABM_socios', compact('registros'));
            } else {
                throw new UsuarioOPasswordErroneosException('login_incorrecto');
            }
        });
	}

	public function logout()
	{
        DB::transaction(function() {
            $user = Sentinel::check();
            $fecha = ControlFechaContable::where('id_usuario', $user->id)->first();
            if($fecha != null)
            {
                ControlFechaContable::where('id_usuario', $user->id)->delete();
            }

            Sentinel::logout();
            return redirect('/login');
        });
	}
}
