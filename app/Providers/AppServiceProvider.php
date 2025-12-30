<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OmsetTurunDetected;
use App\Events\LoginAttempt;
use App\Listeners\SendWhatsAppAlert;
use App\Listeners\LogLoginAttempt;

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
    public function boot(): void
    {
        // Register event listeners
        Event::listen(
            OmsetTurunDetected::class,
            SendWhatsAppAlert::class
        );

        Event::listen(
            LoginAttempt::class,
            LogLoginAttempt::class
        );
    }
}
