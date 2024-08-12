<?php

namespace App\Livewire\App\Backend\DasawismaActivities;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Models\DasawismaActivity;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;

class Delete extends Component
{
    #[Locked]
    public int $id;

    #[On('delete-confirm')]
    public function setData(int $id, string $title): void
    {
        $this->id = $id;

        $this->dispatch('show-modal-confirm', id: $id, title: $title);
    }

    public function render(): View
    {
        return view('livewire.app.backend.dasawisma-activities.delete');
    }

    public function delete(): void
    {
        try {
            $dasawismaActivity = DasawismaActivity::findOrFail($this->id);

            $path = 'storage/image/dasawisma-activities/';
            $image = '';
            if (str_contains($dasawismaActivity->image, 'dasawisma-activities')) {
                $image = str_replace(url("/$path") . "/", '', $dasawismaActivity->image);
            }

            $isSuccess = $dasawismaActivity->delete();

            if ($isSuccess) {
                $dest = public_path($path);
                if (File::exists($dest . $image)) File::delete($dest . $image);

                flasher_success('Data berhasil dihapus.');

                $this->dispatch('refresh-data')->to(Table::class);
            }
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }
    }
}
