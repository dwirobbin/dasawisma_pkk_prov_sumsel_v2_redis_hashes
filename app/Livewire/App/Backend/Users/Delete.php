<?php

namespace App\Livewire\App\Backend\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\File;
use App\Livewire\App\Backend\Users\Card;
use Illuminate\Contracts\View\View;

class Delete extends Component
{
    #[Locked]
    public int $id;

    #[On('delete-confirm')]
    public function setData(int $id, string $name): void
    {
        $this->id = $id;

        $this->dispatch('open-modal', name: $name);
    }

    public function render(): View
    {
        return view('livewire.app.backend.users.delete');
    }

    public function delete(): void
    {
        try {
            $user = User::findOrFail($this->id);

            $path = 'storage/image/profiles/';
            $image = '';
            if (str_contains($user->photo, 'profiles')) {
                $image = str_replace(url("/$path") . "/", '', $user->photo);
            }

            $isSuccess = $user->deleteOrFail();

            if ($isSuccess) {
                $dest = public_path($path);
                if (File::exists($dest . $image)) File::delete($dest . $image);
            }

            flasher_success('Data berhasil dihapus');

            $this->dispatch('refresh-data')->to(Card::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->dispatch('close-modal');
    }
}
