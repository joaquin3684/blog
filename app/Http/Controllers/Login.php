<?php

namespace App\Http\Controllers;




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
		$pum = Sentinel::authenticate($request->all());
		if(Sentinel::check())
		{
		    $registros = [];
		    return view('ABM_socios',compact('registros'));
			return redirect('/asociados');
		} else {
			return ['mierda' => 'caca'];
		}
		return Sentinel::check();
	}

	public function logout()
	{
		Sentinel::logout();
		return redirect('/login');
	}
}
