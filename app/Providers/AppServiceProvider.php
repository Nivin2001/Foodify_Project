<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
  public function boot()
{
    Broadcast::routes(['middleware' => ['auth:sanctum']]);
    require base_path('routes/channels.php');
    Stripe::setApiKey(env('STRIPE_SECRET'));

}
}
