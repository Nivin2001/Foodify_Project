<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event)
    {
        $user = $event->order->user; // جلب المستخدم صاحب الطلب
        $user->notify(new OrderNotification(
            $event->order,
            "Your order #{$event->order->id} has been placed successfully!"
        ));
    }
}
