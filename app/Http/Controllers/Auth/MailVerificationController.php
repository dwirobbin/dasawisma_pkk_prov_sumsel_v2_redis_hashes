<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class MailVerificationController extends Controller
{
    public function show()
    {
        return auth()->user()->hasVerifiedEmail()
            ? to_route('home')
            : view('pages.auth.emails.verification-notice');
    }

    public function verify(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();

        return to_route('verification.verified');
    }

    public function invalid()
    {
        return auth()->user()->hasVerifiedEmail()
            ? to_route('home')
            : view('pages.auth.emails.verification-invalid');
    }

    public function notYet()
    {
        return auth()->user()->hasVerifiedEmail()
            ? to_route('home')
            : view('pages.auth.emails.verification-not-yet');
    }

    public function verified()
    {
        return auth()->user()->hasVerifiedEmail()
            ? to_route('home')
            : view('pages.auth.emails.verification-verified');
    }
}
