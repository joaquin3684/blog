<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudCapitalOtorgado extends Notification implements ShouldQueue
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
        return ['database', 'broadcast'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'titulo' => 'Capital otorgado',
            'detalle' => 'Se le ha otorgado el capital a una solicitud.',
            'url' => '/solicitudesPendientesMutual',
            'tipo' => 'info'
        ];
    }

    public function toBroadcast($notifable)
    {
        return new BroadcastMessage([
            'titulo' => 'Capital otorgado',
            'detalle' => 'Se le ha otorgado el capital a una solicitud.',
            'url' => '/solicitudesPendientesMutual',
            'tipo' => 'info'
        ]);
    }
}
