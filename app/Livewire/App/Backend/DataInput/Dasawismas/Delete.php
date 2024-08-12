<?php

namespace App\Livewire\App\Backend\DataInput\Dasawismas;

use Livewire\Component;
use App\Models\Dasawisma;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\DataInput\Dasawismas\Table;

class Delete extends Component
{
    #[Locked]
    public int $id;

    #[On('delete-confirm')]
    public function deleteConfirm(int $id, string $name): void
    {
        $this->id = $id;

        $this->dispatch('show-modal-confirm', id: $id, name: $name);
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawismas.delete');
    }

    public function delete()
    {
        try {
            Dasawisma::query()
                ->where('id', '=', $this->id)
                ->delete();

            flasher_success('Data berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }
    }
}
