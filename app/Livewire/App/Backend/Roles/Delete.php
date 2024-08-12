<?php

namespace App\Livewire\App\Backend\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Livewire\App\Backend\Roles\Table;
use Illuminate\Contracts\View\View;

class Delete extends Component
{
    #[Locked]
    public int $id;

    #[On('delete-confirm')]
    public function setData(int $id, string $name): void
    {
        $this->id = $id;

        $this->dispatch('show-modal-confirm', id: $id, name: $name);
    }

    public function render(): View
    {
        return view('livewire.app.backend.roles.delete');
    }

    public function delete(): void
    {
        try {
            DB::transaction(function () {
                $role = Role::query()->findOrFail($this->id);

                if ($role->permissions()->exists()) {
                    $role->permissions()->detach([$this->id]);
                }

                $role->deleteOrFail();
            });

            flasher_success('Role berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }
    }
}
