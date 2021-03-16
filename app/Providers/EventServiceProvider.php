<?php

namespace App\Providers;

use App\Listeners\SendMailFired;
use App\Events\NewUserRegistered;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            // \App\Listeners\SendWelcomeEmail::class,
        ],
        // 'App\Events\NewUserRegistered' => [
        //     'App\Listeners\SendMailFired',
        // ],
        NewUserRegistered::class => [
            SendMailFired::class
        ]
        // \App\Events\NewUserRegistered::class => [
        //     \App\Listeners\SendWelcomeEmail::class,
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
