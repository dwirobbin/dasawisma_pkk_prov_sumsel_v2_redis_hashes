<?php

namespace App\Livewire\App\Auth\Passwords;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Rule;

#[Layout('layouts.app')]
#[Title('Lupa Kata Sandi')]

class ForgotPasswordCreate extends Component
{
    #[Rule(
        rule: ['required', 'string', 'email', 'min:6', 'exists:users,email'],
        attribute: 'Email',
        message: [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa string.',
            'email' => ':attribute tidak valid.',
            'min' => 'minimal panjang :attribute :min karakter.',
            'exists' => ':attribute tidak ditemukan.',
        ]
    )]
    public ?string $email = '';

    public function render()
    {
        return view('livewire.app.auth.passwords.forgot-password-create');
    }

    public function sendResetPasswordLink(): void
    {
        $this->validate();

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $email = $this->email;

        $this->reset('email');

        session()->flash('message', ['text' => __($status), 'type' => 'success']);

        $this->redirectRoute('password.notice', parameters: ['email' => $email], navigate: true);
    }
}
