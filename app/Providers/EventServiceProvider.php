<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\SendOrderNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
       protected $listen = [
        OrderPlaced::class => [
            SendOrderNotification::class,
        ],
        PaymentConfirmed::class => [
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
