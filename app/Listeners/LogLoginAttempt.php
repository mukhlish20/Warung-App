<?php

namespace App\Listeners;

use App\Events\LoginAttempt;
use Illuminate\Support\Facades\Log;

class LogLoginAttempt
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
    public function handle(LoginAttempt $event): void
    {
        $level = $event->successful ? 'info' : 'warning';
        $status = $event->successful ? 'SUCCESS' : 'FAILED';

        Log::log($level, "Login attempt: {$status} - Email: {$event->email} - IP: {$event->ip} - UA: {$event->userAgent}");
    }
}
