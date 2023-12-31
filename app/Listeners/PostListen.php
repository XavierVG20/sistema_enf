<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Notifications\PostNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class PostListen
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
    public function handle($event)
    {
        User::all()
        ->except($event->post->user_id)
        ->each(function(User $user) use($event){
            Notification::send($user, new PostNotification($event->post));
        // Notification::send($users, new InvoicePaid($invoice))
            
        });
    }
}
