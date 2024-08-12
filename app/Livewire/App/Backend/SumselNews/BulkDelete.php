<?php

namespace App\Livewire\App\Backend\SumselNews;

use Livewire\Component;
use App\Models\SumselNews;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\File;

class BulkDelete extends Component
{
    #[Locked]
    public array $ids;

    #[On('confirm-delete-selected')]
    public function setData(array $ids): void
    {
        $this->ids = $ids;

        $this->dispatch('show-modal-confirm', total: count($ids));
    }

    public function render(): View
    {
        return view('livewire.app.backend.sumsel-news.bulk-delete');
    }

    public function deleteSelected(): void
    {
        try {
            $sumselNews = SumselNews::whereIn('id', $this->ids);

            $path = 'storage/image/dasawisma-activities/';
            $images = [];
            foreach ($sumselNews->get() as $dasawismaActivity) {
                if (str_contains($dasawismaActivity->image, 'dasawisma-activities')) {
                    $images[] = str_replace(url("/$path") . "/", '', $dasawismaActivity->image);
                }
            }

            $isSuccess = $sumselNews->delete();

            if ($isSuccess) {
                foreach ($images as $item) {
                    $dest = public_path($path);
                    if (File::exists($dest . $item)) File::delete($dest . $item);
                }
            }

            flasher_success('Data yang dipilih berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        } finally {
            $this->dispatch('clear-selected')->to(Table::class);
        }
    }
}
