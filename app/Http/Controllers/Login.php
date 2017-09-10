<?php

namespace App\Http\Controllers;




use App\Exceptions\UsuarioOPasswordErroneosException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;


class Login extends Controller
{
	public function index()
	{
		return view('login');
	}    

	public function login(Request $request)
	{
	    Sentinel::authenticate($request->all());
		if(Sentinel::check())
		{
		    $registros = [];
		    return view('ABM_socios',compact('registros'));
		} else {
            throw new UsuarioOPasswordErroneosException('login_incorrecto');
		}
	}

	public function logout()
	{
		Sentinel::logout();
		return redirect('/login');
	}
}
