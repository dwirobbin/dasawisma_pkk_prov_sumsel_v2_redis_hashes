<?php

namespace App\Livewire\App\Auth\Profiles;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\App\Partials\TopRight;
use Illuminate\Support\Facades\Storage;

class Photo extends Component
{
    use WithFileUploads;

    public ?User $user;

    public object|string|null $photo;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->photo = $user->photo;
    }

    #[On('refresh-photo')]
    public function render(): View
    {
        return view('livewire.app.auth.profiles.photo');
    }

    public function updatedPhoto(): void
    {
        $validatedData = $this->validate([
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048|unique:users,photo,' . $this->user->id,
        ], [
            'image'     => ':attribute harus berupa gambar.',
            'mimes'     => ':attribute harus berformat :values.',
            'max'       => 'Maksimal size :attribute 2 MB.',
            'unique'    => ':attribute sudah ada.',
        ], [
            'photo' => 'Foto',
        ]);

        try {
            if (is_object($validatedData['photo'])) {
                $filePath = 'image/profiles';
                if (Storage::disk('public')->exists($filePath . '/' . $this->user->getRawOriginal('photo'))) {
                    Storage::disk('public')->delete($filePath . '/' . $this->user->getRawOriginal('photo'));
                };

                $newImg = $this->photo->store($filePath, 'public');
                $validatedData['photo'] = str_replace("$filePath/", '', $newImg);
            } else {
                $validatedData['photo'] = $this->user->getRawOriginal('photo');
            }

            $this->user->update($validatedData);

            $this->clearValidation();

            toastr_success('Foto Profil berhasil diperbaharui!');

            $this->dispatch('refresh-top-right')->to(TopRight::class);
        } catch (\Exception $e) {
            toastr_error('Terjadi suatu kesalahan!.');
        }
    }
}
