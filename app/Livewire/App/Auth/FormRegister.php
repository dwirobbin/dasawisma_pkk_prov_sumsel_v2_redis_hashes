<?php

namespace App\Livewire\App\Auth;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class FormRegister extends Component
{
    public ?string $name = null, $username = null, $email = null;
    public ?string $password = null, $password_confirmation = null;

    public function render()
    {
        return view('livewire.app.auth.form-register');
    }

    public function registerHandler()
    {
        $validatedData = $this->validate([
            'name'                  => 'required|string|min:3',
            'username'              => 'required|string|min:3|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:5',
            'password_confirmation' => 'required|min:5|same:password|exclude',
        ], [
            'required'              => ':attribute wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'min'                   => ':attribute minimal :min karakter.',
            'unique'                => ':attribute sudah digunakan.',
            'same'                  => ':attribute harus sama dengan :other.',
        ], [
            'name'                  => 'Nama',
            'username'              => 'Username',
            'email'                 => 'Email',
            'password'              => 'Password',
            'password_confirmation' => 'Password Konfirmasi',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::query()->find(3, 'id');

            $user = new User;
            $user->name     = str($validatedData['name'])->title();
            $user->username = $validatedData['username'];
            $user->email    = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);

            $user->role()->associate($role);
            $user->save();

            event(new Registered($user));

            DB::commit();

            Auth::login($user);
            // session()->flash('message', ['text' => 'Berhasil mendaftar, Silahkan masuk!', 'type' => 'success']);

            // return $this->redirectRoute('auth.login', parameters: ['login-id' => $user->email], navigate: true);
            return $this->redirectRoute('verification.notice', navigate: true);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', ['text' => $ex->getMessage(), 'type' => 'danger']);
        } finally {
            $this->reset();
            $this->dispatch('remove-alert');
        }
    }
}
