<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyBuildings;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyBuilding;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
            $user = auth()->user();

            $prefix = 'data-recap';
            $areaName = 'sumatera-selatan';

            if ($user->role_id === 2) { // Admin
                if ($user->admin->province_id != null && $user->admin->regency_id == null) {
                    // Provinsi
                    $areaName = $user->admin->province->slug;
                } else if ($user->admin->regency_id != null && $user->admin->district_id == null) {
                    // Kabupaten Kota
                    $areaName = $user->admin->regency->slug;
                } else if ($user->admin->district_id != null && $user->admin->village_id == null) {
                    // Kecamatan
                    $areaName = $user->admin->district->slug;
                } else if ($user->admin->village_id != null) {
                    // Kelurahan
                    $areaName = $user->admin->village->slug;
                }
            }

            $dasawisma = Dasawisma::query()
                ->with(['province', 'regency', 'district', 'village'])
                ->where('id', '=', $this->dasawisma_id)
                ->first();

            $hashKeys = [
                $prefix . ':' . $areaName . ":fb:regencies:page-*:" . $dasawisma->regency_id,
                $prefix . ':' . $areaName . ":fb:districts:by-regency:" . $dasawisma->regency->slug . ":page-*:" . $dasawisma->district_id,
                $prefix . ':' . $areaName . ":fb:villages:by-district:" . $dasawisma->district->slug . ":page-*:" . $dasawisma->village_id,
                $prefix . ':' . $areaName . ":fb:dasawismas:by-village:" . $dasawisma->village->slug . ":page-*:" . $dasawisma->id,
                $prefix . ':' . $areaName . ":fb:family-heads:by-dasawisma:" . $dasawisma->slug . ":page-*:" . $this->familyBuilding->family_head_id,
            ];

            $keys = [];
            foreach ($hashKeys as $hashKey) {
                foreach (Redis::keys($hashKey) as $key) {
                    $keys[] = $key;
                }
            }

            Redis::transaction(function ($tx) use ($keys) {
                foreach ($keys as $key) {
                    if ($tx->exists($key)) {

                        // Water Src
                        if ($this->newDataIsExists('PDAM', $this->water_src, $this->familyBuilding->water_src)) {
                            $tx->hIncrBy($key, 'pdam_waters_count', 1);
                        } elseif ($this->oldDataIsExists('PDAM', $this->familyBuilding->water_src, $this->water_src)) {
                            $tx->hIncrBy($key, 'pdam_waters_count', -1);
                        }

                        if ($this->newDataIsExists('Sumur', $this->water_src, $this->familyBuilding->water_src)) {
                            $tx->hIncrBy($key, 'well_waters_count', 1);
                        } elseif ($this->oldDataIsExists('Sumur', $this->familyBuilding->water_src, $this->water_src)) {
                            $tx->hIncrBy($key, 'well_waters_count', -1);
                        }

                        if ($this->newDataIsExists('Sungai', $this->water_src, $this->familyBuilding->water_src)) {
                            $tx->hIncrBy($key, 'river_waters_count', 1);
                        } elseif ($this->oldDataIsExists('Sungai', $this->familyBuilding->water_src, $this->water_src)) {
                            $tx->hIncrBy($key, 'river_waters_count', -1);
                        }

                        if ($this->newDataIsExists('Lainnya', $this->water_src, $this->familyBuilding->water_src)) {
                            $tx->hIncrBy($key, 'etc_waters_count', 1);
                        } elseif ($this->oldDataIsExists('Lainnya', $this->familyBuilding->water_src, $this->water_src)) {
                            $tx->hIncrBy($key, 'etc_waters_count', -1);
                        }

                        // Staple Food
                        if ($this->staple_food === 'Beras' && $this->familyBuilding->staple_food !== 'Beras') {
                            $tx->hIncrBy($key, 'rice_foods_count', 1);
                            $tx->hIncrBy($key, 'etc_rice_foods_count', -1);
                        } elseif ($this->staple_food === 'Non Beras' && $this->familyBuilding->staple_food !== 'Non Beras') {
                            $tx->hIncrBy($key, 'rice_foods_count', -1);
                            $tx->hIncrBy($key, 'etc_rice_foods_count', 1);
                        }

                        // Have Toilet
                        if ($this->have_toilet === 'yes' && $this->familyBuilding->have_toilet !== 1) {
                            $tx->hIncrBy($key, 'have_toilets_count', 1);
                        } elseif ($this->have_toilet === 'no' && $this->familyBuilding->have_toilet === 1) {
                            $tx->hIncrBy($key, 'have_toilets_count', -1);
                        }

                        // Have Landfill
                        if ($this->have_landfill === 'yes' && $this->familyBuilding->have_landfill !== 1) {
                            $tx->hIncrBy($key, 'have_landfills_count', 1);
                        } elseif ($this->have_landfill === 'no' && $this->familyBuilding->have_landfill === 1) {
                            $tx->hIncrBy($key, 'have_landfills_count', -1);
                        }

                        // Have Sewerage
                        if ($this->have_sewerage === 'yes' && $this->familyBuilding->have_sewerage !== 1) {
                            $tx->hIncrBy($key, 'have_sewerages_count', 1);
                        } elseif ($this->have_sewerage === 'no' && $this->familyBuilding->have_sewerage === 1) {
                            $tx->hIncrBy($key, 'have_sewerages_count', -1);
                        }

                        // Pasting P4K Sticker
                        if ($this->pasting_p4k_sticker === 'yes' && $this->familyBuilding->pasting_p4k_sticker !== 1) {
                            $tx->hIncrBy($key, 'pasting_p4k_stickers_count', 1);
                        } elseif ($this->pasting_p4k_sticker === 'no' && $this->familyBuilding->pasting_p4k_sticker === 1) {
                            $tx->hIncrBy($key, 'pasting_p4k_stickers_count', -1);
                        }

                        // House Criteria
                        if ($this->house_criteria === 'Sehat' && $this->familyBuilding->house_criteria !== 'Sehat') {
                            $tx->hIncrBy($key, 'healthy_criterias_count', 1);
                            $tx->hIncrBy($key, 'no_healthy_criterias_count', -1);
                        } elseif ($this->house_criteria === 'Kurang Sehat' && $this->familyBuilding->house_criteria !== 'Kurang Sehat') {
                            $tx->hIncrBy($key, 'healthy_criterias_count', -1);
                            $tx->hIncrBy($key, 'no_healthy_criterias_count', 1);
                        }
                    }
                }
            });

            $this->familyBuilding->update([
                'staple_food'           => $this->staple_food,
                'have_toilet'           => ($this->have_toilet === 'yes') ? true : false,
                'water_src'             => implode(',', (array) $this->water_src),
                'have_landfill'         => ($this->have_landfill === 'yes') ? true : false,
                'have_sewerage'         => ($this->have_sewerage === 'yes') ? true : false,
                'pasting_p4k_sticker'   => ($this->pasting_p4k_sticker === 'yes') ? true : false,
                'house_criteria'        => $this->house_criteria,
            ]);

            toastr_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }

    private function newDataIsExists($search, $newSrc, $oldSrc): bool
    {
        // Mengambil data yang di-checklist
        $newData = array_diff($newSrc, explode(',', $oldSrc));

        return in_array($search, $newData);
    }

    private function oldDataIsExists($search, $oldSrc, $newSrc): bool
    {
        // Mengambil data yang di-unchecklist
        $oldData = array_diff(explode(',', $oldSrc), $newSrc);

        return in_array($search, $oldData);
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
