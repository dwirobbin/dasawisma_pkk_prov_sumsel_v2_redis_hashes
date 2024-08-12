<?php

namespace App\Livewire\App\Auth\Profiles;

use Closure;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Password extends Component
{
    public User $user;
    public ?string $current_password = null, $password = null, $password_confirmation = null;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.app.auth.profiles.password');
    }

    public function saveChangePassword()
    {
        $validatedData = $this->validate([
            'current_password'  => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        return $fail(__('Kata sandi yang anda berikan tidak cocok dengan :attribute.'));
                    }
                },
                'exclude',
            ],
            'password' => [
                'required', 'min:5',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (Hash::check($value, $this->user->password)) {
                        $fail(__(':attribute tidak boleh sama dengan Kata sandi saat ini.'));
                    }
                },
            ],
            'password_confirmation'  => ['required', 'min:5', 'same:password', 'exclude'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'min'       => ':attribute minimal :min karakter.',
            'same'      => ':attribute harus sama dengan :other.',
        ], [
            'current_password'      => 'Kata sandi saat ini',
            'password'              => 'Kata sandi baru',
            'password_confirmation' => 'Konfirmasi kata sandi baru',
        ]);

        try {
            $this->user->update(['password' => Hash::make($validatedData['password'])]);

            flash()->addFlash('success', 'Kata sandi anda berhasil diperbaharui!', 'Sukses', [
                'timeout' => 3000, 'position' => 'top-right'
            ]);
        } catch (\Exception $ex) {
            flash()->addFlash('error', 'Terjadi suatu kesalahan!!', 'Gagal', [
                'timeout' => 3000, 'position' => 'top-right'
            ]);
        } finally {
            $this->resetExcept('user');
            $this->resetValidation();
        }
    }
}
