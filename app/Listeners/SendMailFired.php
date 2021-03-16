<?php

namespace App\Listeners;

use App\Mail\WelcomeUserMail;
use App\Events\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFired
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
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $user = $event->user;
        // dd($event->user['email']);
        // Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
        //     $message->from('taramatee269@gmail.com', 'Taramatee Adhav');
        //     $message->subject('Welcome '.$user->name.'!');
        //     $message->to($user->email);
        // });
        \Mail::to($event->user->email)->send(
            new WelcomeUserMail($event->user)
        );

    }
}
