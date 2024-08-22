<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilySizeMembers;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilySizeMember;
use Illuminate\Database\Eloquent\Collection;

class Edit extends Component
{
    public ?Collection $dasawismas = NULL;

    public ?FamilySizeMember $familySizeMember = NULL;

    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL;
    public ?int $toddlers_number = NULL, $pus_number = NULL, $wus_number = NULL, $blind_people_number = NULL;
    public ?int $pregnant_women_number = NULL, $breastfeeding_mother_number = NULL, $elderly_number = NULL;

    public function mount(?FamilySizeMember $familySizeMember = NULL)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get();

        $this->familySizeMember = $familySizeMember;

        $this->fill([
            'dasawisma_id' => $familySizeMember->dasawisma_id,
            'kk_number' => $familySizeMember->kk_number,
            'family_head' => $familySizeMember->family_head,

            'toddlers_number' => $familySizeMember->toddlers_number,
            'pus_number' => $familySizeMember->pus_number,
            'wus_number' => $familySizeMember->wus_number,
            'blind_people_number' => $familySizeMember->blind_people_number,
            'pregnant_women_number' => $familySizeMember->pregnant_women_number,
            'breastfeeding_mother_number' => $familySizeMember->breastfeeding_mother_number,
            'elderly_number' => $familySizeMember->elderly_number,
        ]);
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-size-members.edit');
    }

    public function saveChange()
    {
        $validatedData = $this->validate(
            [
                'toddlers_number'               => ['required', 'numeric', 'integer'],
                'pus_number'                    => ['required', 'numeric', 'integer'],
                'wus_number'                    => ['required', 'numeric', 'integer'],
                'blind_people_number'           => ['required', 'numeric', 'integer'],
                'pregnant_women_number'         => ['required', 'numeric', 'integer'],
                'breastfeeding_mother_number'   => ['required', 'numeric', 'integer'],
                'elderly_number'                => ['required', 'numeric', 'integer'],
            ],
            [
                'required'  => ':attribute wajib diisi.',
                'numeric'   => ':attribute harus berupa angka.',
                'integer'   => ':attribute harus berupa integer.',
            ],
            [
                'toddlers_number'               => 'Jmlh Balita',
                'pus_number'                    => 'Jmlh PUS',
                'wus_number'                    => 'Jmlh WUS',
                'blind_people_number'           => 'Jmlh Orang Buta',
                'pregnant_women_number'         => 'Jmlh Ibu Hamil',
                'breastfeeding_mother_number'   => 'Jmlh Ibu Menyusui',
                'elderly_number'                => 'Jmlh Lansia',
            ]
        );

        try {
            $this->familySizeMember->update($validatedData);

            toastr_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            toastr_error('Terjadi Suatu Kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
