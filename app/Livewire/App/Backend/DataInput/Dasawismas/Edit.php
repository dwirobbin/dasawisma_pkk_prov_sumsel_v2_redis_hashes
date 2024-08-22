<?php

namespace App\Livewire\App\Backend\DataInput\Dasawismas;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule as ValidationRule;
use App\Livewire\App\Backend\DataInput\Dasawismas\Table;

class Edit extends Component
{
    public ?Dasawisma $dasawisma = null;

    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];

    public ?string $name = null, $rt = null, $rw = null;
    public ?string $province_id = null, $regency_id = null, $district_id = null, $village_id = null;

    #[On('set-data')]
    public function edit(int $id)
    {
        $this->provinces = Province::query()->select('id', 'name')->get();

        $this->dasawisma = Dasawisma::query()->where('id', '=', $id)->first();

        $this->regencies = Regency::query()
            ->select('id', 'name')
            ->where('province_id', '=', $this->dasawisma?->province_id)
            ->get();

        $this->districts = District::query()
            ->select('id', 'name')
            ->where('regency_id', '=', $this->dasawisma?->regency_id)
            ->get();

        $this->villages = Village::query()
            ->select('id', 'name')
            ->where('district_id', '=', $this->dasawisma?->district_id)
            ->get();

        $this->name = $this->dasawisma->name;
        $this->rt = $this->dasawisma->rt;
        $this->rw = $this->dasawisma->rw;
        $this->province_id = $this->dasawisma?->province_id;
        $this->regency_id = $this->dasawisma?->regency_id;
        $this->district_id = $this->dasawisma?->district_id;
        $this->village_id = $this->dasawisma?->village_id;

        $this->dispatch('open-modal-edit');
    }

    public function updatedProvinceId(?string $province_id)
    {
        if ($this->province_id != '') {
            $this->regencies = Regency::query()
                ->select(['id', 'name'])
                ->where('province_id', '=', $province_id)
                ->get();

            $this->reset('district_id', 'village_id');
        } else {
            $this->resetExcept('provinces');
        }
    }

    public function updatedRegencyId($regency_id)
    {
        if ($this->regency_id != '') {
            $this->districts = District::query()
                ->select(['id', 'name'])
                ->where('regency_id', '=', $regency_id)
                ->get();

            $this->reset('village_id');
        } else {
            $this->reset('regency_id', 'districts', 'district_id', 'villages', 'village_id');
        }
    }

    public function updatedDistrictId($district_id)
    {
        if ($this->district_id != '') {
            $this->villages = Village::query()
                ->select(['id', 'name'])
                ->where('district_id', '=', $district_id)
                ->get();
        } else {
            $this->reset('district_id', 'villages', 'village_id');
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawismas.edit');
    }

    public function saveChange()
    {
        $validatedData = $this->validate(
            [
                'name' => 'required|string|min:3|unique:dasawismas,name,' . $this->dasawisma->id,
                'rt' => 'required|numeric|min:1',
                'rw' => 'required|numeric|min:1',
                'province_id' => [
                    'required',
                    ValidationRule::in(Province::query()->pluck('id')->toArray()),
                ],
                'regency_id' => [
                    'required',
                    ValidationRule::in(Regency::query()->pluck('id')->toArray()),
                ],
                'district_id' => [
                    'required',
                    ValidationRule::in(District::query()->pluck('id')->toArray()),
                ],
                'village_id' => [
                    'required',
                    ValidationRule::in(Village::query()->pluck('id')->toArray()),
                ],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa string.',
                'min' => 'Panjang :attribute minimal :min karakter.',
                'unique' => ':attribute sudah ada.',
                'numeric' => ':attribute harus berupa angka.',
                'in' => ':attribute yang dipilih tidak valid.',
            ],
            [
                'name' => 'Nama',
                'rt' => 'Nama',
                'rw' => 'Nama',
                'province_id' => 'Provinsi',
                'regency_id' => 'Kab./Kota',
                'district_id' => 'Kecamatan',
                'village_id' => 'Kel./Desa',
            ]
        );

        try {
            $this->dasawisma->update($validatedData);

            toastr_success('Dasawisma berhasil diperbarui.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        } finally {
            $this->resetForm();
            $this->dispatch('close-modal-edit');
        }
    }

    public function resetForm()
    {
        $this->resetExcept('provinces');
        $this->clearValidation();
    }
}
