<?php

namespace App\Listeners;

use App\Mail\ResetPassword;
use App\Events\PasswordReset;
use App\Mail\PasswordChanged;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Auth\CanResetPassword;

class SendPasswordResetNotification
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
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if ($user instanceof CanResetPassword) {
            Mail::to($user->getEmailForPasswordReset())->send(new PasswordChanged($user, $event->newPassword));
        }
    }
}
