<?php

namespace App\Livewire\App\Backend\Permissions;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\Permissions\Table;
use App\Models\Permission;
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
        return view('livewire.app.backend.permissions.delete');
    }

    public function delete(): void
    {
        try {
            Permission::query()->findOrFail($this->id)->deleteOrFail();

            toastr_success('Data berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->dispatch('close-modal');
    }
}
