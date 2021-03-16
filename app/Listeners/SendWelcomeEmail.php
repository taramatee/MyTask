<?php

namespace App\Listeners;

use App\User;
use App\Events\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        // send the welcome email to the user
        $user = $event->user;
        Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
                $message->from('taramatee269@gmail.com', 'Taramatee Adhav');
                $message->subject('Welcome '.$user->name.'!');
                $message->to($user->email);
        });
        // Mail::to($user->email)->send(new sendMail($user));
        // Mail::to(config('mail.from.address'))->send(new User($event->user));
    }
}
