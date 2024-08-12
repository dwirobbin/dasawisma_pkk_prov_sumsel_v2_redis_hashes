<?php

namespace App\Livewire\App\Backend\DataInput\Dasawismas;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule as ValidationRule;

class Create extends Component
{
    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];

    public ?string $name = null, $rt = null, $rw = null;
    public ?string $province_id = null, $regency_id = null, $district_id = null, $village_id = null;

    public function mount()
    {
        $this->provinces = Province::query()->select('id', 'name')->get();
    }

    public function updatedProvinceId(?string $province_id)
    {
        if ($this->province_id != '') {
            if (auth()->user()->admin->regency_id != null) {
                $this->regencies = Regency::query()
                    ->select(['id', 'name'])
                    ->where('province_id', '=', $province_id)
                    ->where('id', '=', auth()->user()->admin->regency_id)
                    ->get();
            } else {
                $this->regencies = Regency::query()
                    ->select(['id', 'name'])
                    ->where('province_id', '=', $province_id)
                    ->get();
            }

            $this->reset('district_id', 'village_id');
        } else {
            $this->resetExcept('provinces');
        }
    }

    public function updatedRegencyId($regency_id)
    {
        if ($this->regency_id != '') {
            if (auth()->user()->admin->district_id != null) {
                $this->districts = District::query()
                    ->select(['id', 'name'])
                    ->where('regency_id', '=', $regency_id)
                    ->where('id', '=', auth()->user()->admin->district_id)
                    ->get();
            } else {
                $this->districts = District::query()
                    ->select(['id', 'name'])
                    ->where('regency_id', '=', $regency_id)
                    ->get();
            }

            $this->reset('village_id');
        } else {
            $this->reset('regencyId', 'districts', 'district_id', 'villages', 'village_id');
        }
    }

    public function updatedDistrictId($district_id)
    {
        if ($this->district_id != '') {
            if (auth()->user()->admin->village_id != null) {
                $this->villages = Village::query()
                    ->select(['id', 'name'])
                    ->where('district_id', '=', $district_id)
                    ->where('id', '=', auth()->user()->admin->village_id)
                    ->get();
            } else {
                $this->villages = Village::query()
                    ->select(['id', 'name'])
                    ->where('district_id', '=', $district_id)
                    ->get();
            }
        } else {
            $this->reset('district_id', 'villages', 'village_id');
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawismas.create');
    }

    public function save()
    {
        $validatedData = $this->validate(
            [
                'name' => 'required|string|min:3|unique:dasawismas,name',
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
            $dasawisma = Dasawisma::query()
                ->create($validatedData);

            if ($dasawisma->wasRecentlyCreated) {
                flasher_success('Dasawisma berhasil ditambahkan.');

                $this->dispatch('refresh-data')->to(Table::class);
            }
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan');
        } finally {
            $this->resetForm();
            $this->dispatch('close-modal-create');
        }
    }

    public function resetForm()
    {
        $this->resetExcept('provinces');
        $this->clearValidation();
    }
}
