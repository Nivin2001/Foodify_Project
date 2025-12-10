<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentNotification
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
    public function handle(PaymentCompleted $event)
    {
        $payment = $event->payment;
        $user = $payment->order->user;

        $user->notify(new OrderNotification(
            $payment->order,
            "Your payment for order #{$payment->order->id} was successful."
        ));
    }
}
