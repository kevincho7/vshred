<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;

        $data = array('name' => $user->name, 'email'=>$user->email);

        Mail::send('emails.newUser', $data, function($message) use ($user) {

            $message->to($user->email);
            $message->from('kingservant@gmail.com');
            $message->subject('Welcome!');
        });
    }
}
