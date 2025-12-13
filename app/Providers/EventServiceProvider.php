<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\PaymentCompleted;
use App\Listeners\SendOrderNotification;
use App\Listeners\SendPaymentNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
       protected $listen = [
        OrderPlaced::class => [
            SendOrderNotification::class,
        ],
        PaymentCompleted::class => [
            SendPaymentNotification::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
