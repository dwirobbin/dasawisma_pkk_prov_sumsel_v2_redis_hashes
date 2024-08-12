<?php

namespace App\Livewire\App\Auth\Emails;

use Livewire\Component;

class VerificationNotice extends Component
{
    public function render()
    {
        return view('livewire.app.auth.emails.verification-notice');
    }

    public function resendNotification()
    {
        try {
            auth()->user()->sendEmailVerificationNotification();

            session()->flash('message', ['text' => 'Tautan ulang verifikasi telah dikirim.', 'type' => 'success']);
        } catch (\Throwable $th) {
            session()->flash('message', ['text' => 'Terjadi suatu kesalahan!!', 'type' => 'danger']);
        } finally {
            $this->dispatch('remove-alert');
        }
    }

    public function logoutHandler()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirectRoute('auth.login', navigate: true);
    }
}
