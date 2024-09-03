<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilySizeMembers;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilySizeMember;
use Illuminate\Support\Facades\Redis;
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
                $prefix . ':' . $areaName . ":fn:regencies:page-*:" . $dasawisma->regency_id,
                $prefix . ':' . $areaName . ":fn:districts:by-regency:" . $dasawisma->regency->slug . ":page-*:" . $dasawisma->district_id,
                $prefix . ':' . $areaName . ":fn:villages:by-district:" . $dasawisma->district->slug . ":page-*:" . $dasawisma->village_id,
                $prefix . ':' . $areaName . ":fn:dasawismas:by-village:" . $dasawisma->village->slug . ":page-*:" . $dasawisma->id,
                $prefix . ':' . $areaName . ":fn:family-heads:by-dasawisma:" . $dasawisma->slug . ":page-*:" . $this->familySizeMember->family_head_id,
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

                        // Balita
                        if ($this->toddlers_number > $this->familySizeMember->toddlers_number) {
                            $tx->hIncrBy($key, 'toddlers_sum', $this->toddlers_number - $this->familySizeMember->toddlers_number); // incr
                        } else if ($this->toddlers_number < $this->familySizeMember->toddlers_number) {
                            $tx->hIncrBy($key, 'toddlers_sum', - ($this->familySizeMember->toddlers_number - $this->toddlers_number)); // decr
                        }

                        // Pasangan Usia Subur
                        if ($this->pus_number > $this->familySizeMember->pus_number) {
                            $tx->hIncrBy($key, 'pus_sum', $this->pus_number - $this->familySizeMember->pus_number); // incr
                        } else if ($this->pus_number < $this->familySizeMember->pus_number) {
                            $tx->hIncrBy($key, 'pus_sum', - ($this->familySizeMember->pus_number - $this->pus_number)); // decr
                        }

                        // Wanita Usia Subur
                        if ($this->wus_number > $this->familySizeMember->wus_number) {
                            $tx->hIncrBy($key, 'wus_sum', $this->wus_number - $this->familySizeMember->wus_number); // incr
                        } else if ($this->wus_number < $this->familySizeMember->wus_number) {
                            $tx->hIncrBy($key, 'wus_sum', - ($this->familySizeMember->wus_number - $this->wus_number)); // decr
                        }

                        // Orang Buta
                        if ($this->blind_people_number > $this->familySizeMember->blind_people_number) {
                            $tx->hIncrBy($key, 'blind_peoples_sum', $this->blind_people_number - $this->familySizeMember->blind_people_number); // incr
                        } else if ($this->blind_people_number < $this->familySizeMember->blind_people_number) {
                            $tx->hIncrBy($key, 'blind_peoples_sum', - ($this->familySizeMember->blind_people_number - $this->blind_people_number)); // decr
                        }

                        // Wanita Hamil
                        if ($this->pregnant_women_number > $this->familySizeMember->pregnant_women_number) {
                            $tx->hIncrBy($key, 'pregnant_womens_sum', $this->pregnant_women_number - $this->familySizeMember->pregnant_women_number); // incr
                        } else if ($this->pregnant_women_number < $this->familySizeMember->pregnant_women_number) {
                            $tx->hIncrBy($key, 'pregnant_womens_sum', - ($this->familySizeMember->pregnant_women_number - $this->pregnant_women_number)); // decr
                        }

                        // Ibu Menyusui
                        if ($this->breastfeeding_mother_number > $this->familySizeMember->breastfeeding_mother_number) {
                            $tx->hIncrBy($key, 'breastfeeding_mothers_sum', $this->breastfeeding_mother_number - $this->familySizeMember->breastfeeding_mother_number); // incr
                        } else if ($this->breastfeeding_mother_number < $this->familySizeMember->breastfeeding_mother_number) {
                            $tx->hIncrBy($key, 'breastfeeding_mothers_sum', - ($this->familySizeMember->breastfeeding_mother_number - $this->breastfeeding_mother_number)); // incr
                        }

                        // Lansia
                        if ($this->elderly_number > $this->familySizeMember->elderly_number) {
                            $tx->hIncrBy($key, 'elderlies_sum', $this->elderly_number - $this->familySizeMember->elderly_number); // incr
                        } else if ($this->elderly_number < $this->familySizeMember->elderly_number) {
                            $tx->hIncrBy($key, 'elderlies_sum', - ($this->elderly_number - $this->familySizeMember->elderly_number)); // decr
                        }
                    }
                }
            });

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
