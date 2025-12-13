<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
      protected $order;
    protected $message;

    public function __construct($order, $message)
    {
        $this->order = $order;
        $this->message = $message;
    }

       public function via($notifiable)
    {
        return ['database','broadcast']; // نخزنها في DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id ?? null,
            'message' => $this->message,
        ];
    }

    public function toBroadcast($notifiable)
{
    return new \Illuminate\Notifications\Messages\BroadcastMessage([
        'order_id' => $this->order->id,
        'message'  => $this->message,
    ]);
}


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
