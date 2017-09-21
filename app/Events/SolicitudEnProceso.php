<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 18/09/17
 * Time: 14:45
 */

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitudEnProceso implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function broadcastWith()
    {
        return ['id' => $this->solicitud->estado];
    }

    public function broadcastOn()
    {
        return new Channel("prueba");
    }
}