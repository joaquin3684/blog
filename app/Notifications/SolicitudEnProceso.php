<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudEnProceso extends Notification implements ShouldQueue
{
    use Queueable;

    public $solicitud;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];//todo lo del mail esta semi configurado hay que preguntarle cosas a la mutual
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('agente_financiero');/*
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Solicitud en proceso',
            'detalle' => 'La solicitud esta en estado '. $this->solicitud->getEstado(),
            'url' => '/solicitudesPendientesMutual'
        ];
    }

    public function toBroadcast($notifable)
    {
        return new BroadcastMessage([
            'mensaje' => 'Hay una solicitud en proceso',
            ]);
    }
}
