<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyMembers;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\FamilyMember;
use Livewire\Attributes\Locked;
use App\Livewire\App\Backend\DataInput\Members\FamilyMembers\Table;

class Delete extends Component
{
    public ?FamilyMember $familyMember = null;

    #[Locked]
    public ?int $id = NULL;

    public ?string $name = '';

    #[On('delete-fm-confirm')]
    public function deleteConfirm(?int $id = NULL, ?string $name = ''): void
    {
        $this->id = $id;
        $this->name = $name;

        $this->dispatch('open-fm-modal', name: $name);
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-members.delete');
    }

    public function delete()
    {
        try {
            $familyMember = FamilyMember::query()
                ->select([
                    'family_members.id',
                    'family_members.gender',
                    'family_members.marital_status',
                    'family_members.last_education',
                    'family_members.profession',
                    'family_members.family_head_id',
                    'family_heads.dasawisma_id',
                    'dasawismas.slug AS dasawisma_slug',
                    'dasawismas.province_id',
                    'dasawismas.regency_id',
                    'dasawismas.district_id',
                    'dasawismas.village_id',
                ])
                ->join('family_heads', 'family_members.family_head_id', '=', 'family_heads.id')
                ->join('dasawismas', 'family_heads.dasawisma_id', '=', 'dasawismas.id')
                ->where('family_members.id', '=', $this->id)
                ->first();

            $familyMember->delete();

            flasher_success('Data berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->resetForm();
        $this->dispatch('close-fm-modal');
    }

    public function resetForm()
    {
        $this->resetExcept('familyMember');
    }
}
