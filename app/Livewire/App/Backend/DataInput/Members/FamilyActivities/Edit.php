<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyActivities;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyActivity;
use Illuminate\Support\Facades\Redis;

class Edit extends Component
{
    public array $dasawismas = [];

    public ?FamilyActivity $familyActivity = NULL;

    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL;
    public array $up2k_activities = [], $current_up2k_activities = [];
    public array $env_health_activities = [], $current_env_health_activities = [];

    public function mount(?FamilyActivity $familyActivity = NULL)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get()->toArray();

        if (preg_match_all('~\(([^()]*)\)~', $familyActivity->up2k_activity, $matches)) {
            $this->current_up2k_activities = $matches[1]; // Get Group 1 values
        } else {
            $this->current_up2k_activities = explode(',', $familyActivity->up2k_activity);
        }

        if (preg_match_all('~\(([^()]*)\)~', $familyActivity->env_health_activity, $matches)) {
            $this->current_env_health_activities = $matches[1]; // Get Group 1 values
        } else {
            $this->current_env_health_activities = explode(',', $familyActivity->env_health_activity);
        }

        $this->fill([
            'dasawisma_id' => $familyActivity->dasawisma_id,
            'kk_number' => $familyActivity->kk_number,
            'family_head' => $familyActivity->family_head,
        ]);

        foreach ($this->current_up2k_activities as $itemUp2kActivity) {
            array_push($this->up2k_activities, [
                'name' => $itemUp2kActivity,
            ]);
        }

        foreach ($this->current_env_health_activities as $itemEnvHealthActivity) {
            array_push($this->env_health_activities, [
                'name' => $itemEnvHealthActivity,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-activities.edit');
    }

    public function addUp2kActivity()
    {
        $this->up2k_activities[] = [
            'name'  => '',
        ];
    }

    public function removeUp2kActivity($index)
    {
        unset($this->up2k_activities[$index]);
        $this->up2k_activities = array_values($this->up2k_activities);
    }

    public function addEnvHealthActivity()
    {
        $this->env_health_activities[] = [
            'name'  => '',
        ];
    }

    public function removeEnvHealthActivity($index)
    {
        unset($this->env_health_activities[$index]);
        $this->env_health_activities = array_values($this->env_health_activities);
    }

    public function saveChange()
    {
        $this->validate(
            [
                'up2k_activities'               => ['nullable', 'array'],
                'up2k_activities.*.name'        => ['nullable', 'string', 'min:5'],
                'env_health_activities'         => ['nullable', 'array'],
                'env_health_activities.*.name'  => ['nullable', 'string', 'min:5'],
            ],
            [
                'string' => ':attribute :position harus berupa string.',
                'min'    => ':attribute :position harus setidaknya terdiri dari :min karakter.',
            ],
            [
                'up2k_activities.*.name'        => 'Kegiatan UP2K',
                'env_health_activities.*.name'    => 'Kegiatan Usaha Kesehatan Lingkungan',
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
                'keyRegency' => $prefix . ':' . $areaName . ":fa:regencies:page-*:" . $dasawisma->regency_id,
                'keyDistrict' => $prefix . ':' . $areaName . ":fa:districts:by-regency:" . $dasawisma->regency->slug . ":page-*:" . $dasawisma->district_id,
                'keyVillage' => $prefix . ':' . $areaName . ":fa:villages:by-district:" . $dasawisma->district->slug . ":page-*:" . $dasawisma->village_id,
                'keyDasawisma' => $prefix . ':' . $areaName . ":fa:dasawismas:by-village:" . $dasawisma->village->slug . ":page-*:" . $dasawisma->id,
                'keyFamilyHead' => $prefix . ':' . $areaName . ":fa:family-heads:by-dasawisma:" . $dasawisma->slug . ":page-*:" . $this->familyActivity->family_head_id,
            ];

            $keys = [];
            foreach ($hashKeys as $key => $hashKey) {
                foreach (Redis::keys($hashKey) as $value) {
                    $keys[$key] = $value;
                }
            }

            Redis::transaction(function ($tx) use ($keys) {
                foreach ($keys as $key => $value) {
                    if ($tx->exists($value)) {

                        // Action for key 'keyFamilyHead'
                        if ($key === 'keyFamilyHead') {

                            // Usaha Peningkatan Pendapatan Keluarga
                            if (count($this->up2k_activities) > count($this->current_up2k_activities)) {
                                $tx->hIncrBy($value, 'up2k_activities_sum', count($this->up2k_activities) - count($this->current_up2k_activities)); // incr
                                $tx->hSet($value, 'up2k_activity', $this->multiImplode($this->up2k_activities, ','));
                            }
                            if (count($this->up2k_activities) < count($this->current_up2k_activities)) {
                                $tx->hIncrBy($value, 'up2k_activities_sum', - (count($this->current_up2k_activities) - count($this->up2k_activities))); // decr
                                $tx->hSet($value, 'up2k_activity', $this->multiImplode($this->up2k_activities, ','));
                            }

                            // Usaha Kegiatan Kesehatan Lingkungan
                            if (count($this->env_health_activities) > count($this->current_env_health_activities)) {
                                $tx->hIncrBy($value, 'env_health_activities_sum', count($this->env_health_activities) - count($this->current_env_health_activities)); // incr
                                $tx->hSet($value, 'env_health_activity', $this->multiImplode($this->env_health_activities, ','));
                            }
                            if (count($this->env_health_activities) < count($this->current_env_health_activities)) {
                                $tx->hIncrBy($value, 'env_health_activities_sum', - (count($this->current_env_health_activities) - count($this->env_health_activities))); // decr
                                $tx->hSet($value, 'env_health_activity', $this->multiImplode($this->env_health_activities, ','));
                            }
                        } else {
                            // Usaha Peningkatan Pendapatan Keluarga
                            if (count($this->up2k_activities) > count($this->current_up2k_activities)) {
                                $tx->hIncrBy($value, 'up2k_activities_sum', count($this->up2k_activities) - count($this->current_up2k_activities)); // incr
                            }
                            if (count($this->up2k_activities) < count($this->current_up2k_activities)) {
                                $tx->hIncrBy($value, 'up2k_activities_sum', - (count($this->current_up2k_activities) - count($this->up2k_activities))); // decr
                            }

                            // Usaha Kegiatan Kesehatan Lingkungan
                            if (count($this->env_health_activities) > count($this->current_env_health_activities)) {
                                $tx->hIncrBy($value, 'env_health_activities_sum', count($this->env_health_activities) - count($this->current_env_health_activities)); // incr
                            }
                            if (count($this->env_health_activities) < count($this->current_env_health_activities)) {
                                $tx->hIncrBy($value, 'env_health_activities_sum', - (count($this->current_env_health_activities) - count($this->env_health_activities))); // decr
                            }
                        }
                    }
                }
            });

            $this->familyActivity->update([
                'up2k_activity'         => $this->multiImplode($this->up2k_activities, ','),
                'env_health_activity'   => $this->multiImplode($this->env_health_activities, ','),
            ]);

            toastr_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }

    private function multiImplode(array $array, string $glue)
    {
        $prefix = '(';
        $suffix = ')';
        $gluedString = '';

        foreach ($array as $item) {
            if (is_array($item)) {
                $gluedString .= $prefix . $this->multiImplode($item, $glue) . $suffix . $glue;
            } else {
                $gluedString .= $item . $glue;
            }
        }

        $gluedString = substr($gluedString, 0, 0 - strlen($glue));

        return $gluedString;
    }

    public function resetForm()
    {
        $this->reset();
        $this->clearValidation();
    }
}
