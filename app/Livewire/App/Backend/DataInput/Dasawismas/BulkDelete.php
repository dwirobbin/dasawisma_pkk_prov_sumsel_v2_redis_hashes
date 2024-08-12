<?php

namespace App\Livewire\App\Backend\DataInput\Dasawismas;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\DataInput\Dasawismas\Table;
use App\Models\Dasawisma;

class BulkDelete extends Component
{
    #[Locked]
    public array $ids;

    #[On('confirm-bulk-delete')]
    public function setData(array $ids): void
    {
        $this->ids = $ids;

        $this->dispatch('show-modal-confirm', total: count($ids));
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawismas.bulk-delete');
    }

    public function deleteSelected(): void
    {
        try {
            $isSuccess = Dasawisma::query()
                ->whereIn('id', $this->ids)
                ->delete();

            if ($isSuccess) {
                flasher_success('Data yang dipilih berhasil dihapus.');

                $this->dispatch('refresh-data')->to(Table::class);
            }
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        } finally {
            $this->dispatch('clear-selected')->to(Table::class);
        }
    }
}
