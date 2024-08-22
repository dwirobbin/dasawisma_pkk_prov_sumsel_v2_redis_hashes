<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyHeads;

use Livewire\Component;
use App\Models\FamilyHead;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\DataInput\Members\FamilyHeads\Table;

class Delete extends Component
{
    public ?FamilyHead $familyHead = null;

    #[Locked]
    public ?int $id = NULL;

    public ?string $name = NULL;

    #[On('delete-fh-confirm')]
    public function deleteConfirm(int $id, string $name): void
    {
        $this->id = $id;
        $this->name = $name;

        $this->dispatch('open-fh-modal', name: $name);
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-heads.delete');
    }

    public function delete()
    {
        try {
            FamilyHead::query()->findOrFail($this->id)->delete();

            toastr_success('Data berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->resetForm();
        $this->dispatch('close-fh-modal');
    }

    public function resetForm()
    {
        $this->reset('id', 'name');
    }
}
