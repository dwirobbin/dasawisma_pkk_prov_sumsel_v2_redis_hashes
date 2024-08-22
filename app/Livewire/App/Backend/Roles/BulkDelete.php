<?php

namespace App\Livewire\App\Backend\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Livewire\App\Backend\Roles\Table;
use Illuminate\Contracts\View\View;

class BulkDelete extends Component
{
    #[Locked]
    public array $IDs;

    #[On('confirm-delete-selected')]
    public function setData(array $IDs): void
    {
        $this->IDs = $IDs;

        $this->dispatch('show-modal-confirm', total: count($IDs));
    }

    public function render(): View
    {
        return view('livewire.app.backend.roles.bulk-delete');
    }

    public function deleteSelected(): void
    {
        try {
            DB::transaction(function () {
                Role::whereIn('id', $this->IDs)->get()->map(function (Role $role) {
                    if ($role->permissions()->exists()) {
                        $role->permissions()->detach([$role->id]);
                    }

                    $role->deleteOrFail();
                });
            });

            toastr_success('Role yang dipilih berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->dispatch('clear-selected')->to(Table::class);
    }
}
