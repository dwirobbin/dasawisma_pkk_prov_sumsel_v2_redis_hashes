<?php

namespace App\Livewire\App\Auth\Profiles;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Livewire\App\Partials\TopRight;
use Illuminate\Validation\Rule as ValidationRule;

class BioData extends Component
{
    public User $user;
    public ?string $name, $username, $email, $phone_number;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone_number = $user->admin?->phone_number;
    }

    public function render()
    {
        return view('livewire.app.auth.profiles.bio-data');
    }

    public function saveChangeProfileDetail()
    {
        $validatedData = $this->validate([
            'name'          => ['required', 'string', 'min:3'],
            'username'      => ['required', 'string', 'min:3', ValidationRule::unique('users', 'username')->ignore($this->user->id, 'id')],
            'email'         => ['required', 'email', ValidationRule::unique('users', 'email')->ignore($this->user->id, 'id')],
            'phone_number'  => ['required', 'numeric'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'email'     => ':attribute tidak valid.',
            'numeric'   => ':attribute harus berupa angka.',
            'min'       => ':attribute minimal :min karakter.',
            'unique'    => ':attribute sudah digunakan.',
        ], [
            'name'          => 'Nama',
            'username'      => 'Username',
            'email'         => 'Email',
            'phone_number'  => 'No. Telepon',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $this->user->update([
                    'name' => $validatedData['name'],
                    'username' => $validatedData['username'],
                    'email' => $validatedData['email'],
                ]);

                $this->user->admin->update([
                    'phone_number' => $validatedData['phone_number'],
                ]);
            });

            flash()->addFlash('success', 'Detail Profil berhasil diperbaharui!', 'Sukses', [
                'timeout' => 3000, 'position' => 'top-right'
            ]);
        } catch (\Exception $ex) {
            flash()->addFlash('error', 'Terjadi suatu kesalahan!!', 'Gagal', [
                'timeout' => 3000, 'position' => 'top-right'
            ]);
        } finally {
            $this->resetValidation();

            $this->dispatch('refresh-top-right')->to(TopRight::class);
            $this->dispatch('refresh-photo')->to(Photo::class);
        }
    }
}
