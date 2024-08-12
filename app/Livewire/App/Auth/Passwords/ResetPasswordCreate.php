<?php

namespace App\Livewire\App\Auth\Passwords;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Events\PasswordReset;
use Livewire\Attributes\Locked;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
// use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordCreate extends Component
{
    #[Locked]
    public ?string $token = '';
    public ?string $email = '';
    public ?string $password = '';
    public ?string $password_confirmation = '';

    public function mount(string $token, string $email): void
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function render()
    {
        return view('livewire.app.auth.passwords.reset-password-create');
    }

    public function update()
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email', 'min:6', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'min:8', Rules\Password::defaults(), 'same:password', 'exclude'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'email'     => ':attribute tidak valid.',
            'min'       => 'Panjang :attribute minimal :min karakter.',
            'same'      => ':attribute harus sama dengan :other.',
        ], [
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user, Crypt::encrypt($this->password)));
            }
        );

        if ($status != Password::PASSWORD_RESET) {

            if ($status == Password::INVALID_TOKEN) {
                flash_message('Token kadaluarsa, kirim ulang tautan reset kata sandi!', 'fail');

                $this->redirect(route('password.request'), true);

                return;
            }

            $this->addError('email', __($status));

            return;
        }

        flash_message(__($status), 'success');

        $this->dispatch('remove-alert');

        $this->redirect(route('auth.login'), true);
    }
}
