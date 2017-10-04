<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class NotificacionController extends Controller
{

    public function marcarComoLeida(Request $request)
    {
        DB::transaction(function () use ($request){
            $id = $request['id'];
            $user = Sentinel::check();
            $notification = $user->notifications()->where('id', $id)->first();
            if($notification)
            {
                $notification->delete();
            } else {
                throw new NotFoundException('not_found');
            }
        });

    }

    public function notificaciones()
    {
        $user = Sentinel::check();

        return $user->notifications;

    }

    public function marcarTodasLeidas()
    {
        DB::transaction(function () {
            $user = Sentinel::check();
            $user->unreadNotifications->each(function($notification){
                $notification->delete();
            });
        });
    }

}
