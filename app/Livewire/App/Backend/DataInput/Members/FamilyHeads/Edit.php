<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyHeads;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyHead;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule as ValidationRule;
use App\Livewire\App\Backend\DataInput\Members\FamilyHeads\Table;

class Edit extends Component
{
    public ?Collection $dasawismas = null;
    public ?FamilyHead $familyHead = null;

    public ?string $dasawisma_id = null, $kk_number = null, $family_head = null;

    #[On('set-data')]
    public function edit(int $id)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get();

        $this->familyHead = FamilyHead::query()->where('id', '=', $id)->firstOrFail();

        $this->fill([
            'dasawisma_id' => $this->familyHead->dasawisma_id,
            'kk_number' => $this->familyHead->kk_number,
            'family_head' => $this->familyHead->family_head,
        ]);

        $this->dispatch('open-modal-family-head-edit');
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-heads.edit');
    }

    public function saveChange()
    {
        $this->validate(
            [
                'dasawisma_id'  => ['nullable', 'string', ValidationRule::in($this->dasawismas->pluck('id')->toArray())],
                'kk_number'     => ['required', 'numeric', 'min:16', 'unique:family_heads,kk_number,' . $this->familyHead->id],
                'family_head'   => ['required', 'string', 'min:3'],
            ],
            [
                'required'      => ':attribute wajib diisi.',
                'string'        => ':attribute harus berupa string.',
                'numeric'       => ':attribute harus berupa angka.',
                'min'           => ':attribute harus setidaknya terdiri dari :min karakter.',
                'unique'        => ':attribute sudah ada.',
                'kk_number.min' => ':attribute harus setidaknya terdiri dari :min angka.',
                'in'            => ':attribute yang dipilih tidak valid.',
            ],
            [
                'dasawisma_id'  => 'Dasawisma',
                'kk_number'     => 'No. KK',
                'family_head'   => 'Nama Kepala Keluarga',
            ]
        );

        try {
            $this->familyHead->update([
                'dasawisma_id'  => $this->dasawisma_id ?: null,
                'kk_number'     => $this->kk_number,
                'family_head'   => str($this->family_head)->title(),
                'created_by'    => auth()->id(),
            ]);

            $this->dispatch('refresh-data')->to(Table::class);

            toastr_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->dispatch('close-modal-family-head-edit');
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
