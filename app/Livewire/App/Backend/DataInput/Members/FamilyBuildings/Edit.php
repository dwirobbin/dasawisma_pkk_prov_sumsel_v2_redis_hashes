<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyBuildings;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyBuilding;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule as ValidationRule;

class Edit extends Component
{
    public ?Collection $dasawismas = NULL;

    public ?FamilyBuilding $familyBuilding = NULL;

    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL;
    public array $water_src = [];
    public ?string $staple_food = NULL, $house_criteria = NULL;
    public ?string $have_toilet = NULL, $have_landfill = NULL, $have_sewerage = NULL, $pasting_p4k_sticker = NULL;

    public function mount(?FamilyBuilding $familyBuilding = NULL)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get();

        $this->familyBuilding = $familyBuilding;

        $this->fill([
            'dasawisma_id' => $familyBuilding->dasawisma_id,
            'kk_number' => $familyBuilding->kk_number,
            'family_head' => $familyBuilding->family_head,

            'water_src' => explode(',', $familyBuilding->water_src),
            'staple_food' => $familyBuilding->staple_food,
            'have_toilet' => ($familyBuilding->have_toilet === 1) ? 'yes' : 'no',
            'have_landfill' => ($familyBuilding->have_landfill === 1) ? 'yes' : 'no',
            'have_sewerage' => ($familyBuilding->have_sewerage === 1) ? 'yes' : 'no',
            'pasting_p4k_sticker' => ($familyBuilding->pasting_p4k_sticker === 1) ? 'yes' : 'no',
            'house_criteria' => $familyBuilding->house_criteria,
        ]);
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-buildings.edit');
    }

    public function saveChange()
    {
        $this->validate(
            [
                'water_src'             => ['required', 'array'],
                'staple_food'           => ['required', 'string', ValidationRule::in(['Beras', 'Non Beras'])],
                'have_toilet'           => ['required', 'string', 'in:yes,no'],
                'have_landfill'         => ['required', 'string', 'in:yes,no'],
                'have_sewerage'         => ['required', 'string', 'in:yes,no'],
                'pasting_p4k_sticker'   => ['required', 'string', 'in:yes,no'],
                'house_criteria'        => ['required', 'string', ValidationRule::in(['Sehat', 'Kurang Sehat'])],
            ],
            [
                'required'  => ':attribute wajib diisi.',
                'array'     => ':attribute harus berupa string.',
                'string'    => ':attribute harus berupa string.',
                'boolean'   => ':attribute harus bernilai Ya atau Tidak.',
                'in'        => ':attribute yang dipilih tidak valid.',
            ],
            [
                'water_src'             => 'Sumber Air Keluarga',
                'staple_food'           => 'Makanan Pokok',
                'have_toilet'           => 'Mempunyai Toilet',
                'have_landfill'         => 'Mempunyai TPS',
                'have_sewerage'         => 'Mempunyai SPAL',
                'pasting_p4k_sticker'   => 'Menempel Stiker P4K',
                'house_criteria'        => 'Kriteria Rumah',
            ]
        );

        try {
            $this->familyBuilding->update([
                'staple_food'           => $this->staple_food,
                'have_toilet'           => ($this->have_toilet === 'yes') ? true : false,
                'water_src'             => implode(',', (array) $this->water_src),
                'have_landfill'         => ($this->have_landfill === 'yes') ? true : false,
                'have_sewerage'         => ($this->have_sewerage === 'yes') ? true : false,
                'pasting_p4k_sticker'   => ($this->pasting_p4k_sticker === 'yes') ? true : false,
                'house_criteria'        => $this->house_criteria,
            ]);

            flasher_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
