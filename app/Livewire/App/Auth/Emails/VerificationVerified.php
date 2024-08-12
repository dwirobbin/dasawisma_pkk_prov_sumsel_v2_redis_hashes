<?php

namespace App\Livewire\App\Auth\Emails;

use Livewire\Component;

class VerificationVerified extends Component
{
    public function render()
    {
        return view('livewire.app.auth.emails.verification-verified');
    }

    public function logoutHandler()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirectRoute('auth.login', navigate: true);
    }
}
