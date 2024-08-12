<?php

namespace App\Livewire\App\Backend\Permissions;

use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\Permissions\Table;
use Illuminate\Contracts\View\View;

class BulkDelete extends Component
{
    #[Locked]
    public array $IDs;

    #[On('confirm-delete-selected')]
    public function setData(array $IDs): void
    {
        $this->IDs = $IDs;

        $this->dispatch('open-modal', total: count($IDs));
    }

    public function render(): View
    {
        return view('livewire.app.backend.permissions.bulk-delete');
    }

    public function deleteSelected(): void
    {
        try {
            Permission::query()
                ->whereIn('id', $this->IDs)
                ->deleteOrFail();

            flasher_success('Data yang dipilih berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->dispatch('clear-selected')->to(Table::class);
        $this->dispatch('close-modal');
    }
}
