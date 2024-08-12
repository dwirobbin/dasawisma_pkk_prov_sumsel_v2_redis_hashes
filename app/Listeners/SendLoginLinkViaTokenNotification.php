<?php

namespace App\Listeners;

use App\Events\LoginViaToken;
use App\Notifications\LoginViaToken as NotificationsLoginViaToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendLoginLinkViaTokenNotification
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
    public function handle(LoginViaToken $event): void
    {
        $event->user->notify(new NotificationsLoginViaToken($event->link));
    }
}
