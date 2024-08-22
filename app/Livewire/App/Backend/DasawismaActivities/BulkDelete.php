<?php

namespace App\Livewire\App\Backend\DasawismaActivities;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Models\DasawismaActivity;
use Illuminate\Contracts\View\View;
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
        return view('livewire.app.backend.dasawisma-activities.bulk-delete');
    }

    public function deleteSelected(): void
    {
        try {
            $dasawismaActivities = DasawismaActivity::query()->whereIn('id', $this->ids);

            $path = 'storage/image/dasawisma-activities/';
            $images = [];
            foreach ($dasawismaActivities->get() as $dasawismaActivity) {
                if (str_contains($dasawismaActivity->image, 'dasawisma-activities')) {
                    $images[] = str_replace(url("/$path") . "/", '', $dasawismaActivity->image);
                }
            }

            $isSuccess = $dasawismaActivities->delete();

            if ($isSuccess) {
                foreach ($images as $item) {
                    $dest = public_path($path);
                    if (File::exists($dest . $item)) File::delete($dest . $item);
                }

                toastr_success('Data yang dipilih berhasil dihapus.');

                $this->dispatch('refresh-data')->to(Table::class);
            }
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        } finally {
            $this->dispatch('clear-selected')->to(Table::class);
        }
    }
}
