<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyMembers;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyHead;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule as ValidationRule;

class Edit extends Component
{
    public ?Collection $dasawismas = NULL;

    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL, $family_head_id = NULL;
    public array $family_members = [], $current_family_members = [];

    public function mount(array $familyMembers)
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get();

        foreach ($familyMembers as $index => $familyMember) {
            if ($index === array_key_first($familyMembers)) {
                $this->dasawisma_id = $familyMember['dasawisma_id'];
                $this->kk_number = $familyMember['kk_number'];
                $this->family_head = $familyMember['family_head'];
                $this->family_head_id = $familyMember['family_head_id'];
            }

            array_push($this->family_members, [
                'id'                    => $familyMember['id'],
                'family_head_id'        => $familyMember['family_head_id'],
                'nik_number'            => $familyMember['nik_number'],
                'name'                  => $familyMember['name'],
                'birth_date'            => $familyMember['birth_date'],
                'status'                => $familyMember['status'],
                'marital_status'        => $familyMember['marital_status'],
                'gender'                => $familyMember['gender'],
                'last_education'        => $familyMember['last_education'],
                'profession'            => $familyMember['profession'],
            ]);
        }

        $this->current_family_members = $familyMembers;
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-members.edit');
    }

    public function addFamilyMember()
    {
        $this->family_members[] = [
            'nik_number'        => '',
            'name'              => '',
            'birth_date'        => '',
            'status'            => '',
            'marital_status'    => '',
            'gender'            => '',
            'last_education'    => '',
            'profession'        => '',
        ];
    }

    public function removeFamilyMember($index)
    {
        unset($this->family_members[$index]);
        $this->family_members = array_values($this->family_members);
    }

    public function saveChange()
    {
        $this->validate(
            [
                'family_members'                    => ['required', 'array'],
                'family_members.*.nik_number'       => ['nullable', 'numeric', 'min:16'],
                'family_members.*.name'             => ['required', 'string', 'min:3'],
                'family_members.*.birth_date'       => ['required', 'string', 'date'],
                'family_members.*.status'           => ['required', 'string', ValidationRule::in([
                    'Kepala Keluarga',
                    'Istri',
                    'Anak',
                    'Keluarga',
                    'Orang Tua',
                ])],
                'family_members.*.marital_status'   => ['required', 'string', ValidationRule::in([
                    'Kawin',
                    'Janda',
                    'Duda',
                    'Belum Kawin',
                ])],
                'family_members.*.gender'           => ['required', 'string', 'in:Laki-laki,Perempuan'],
                'family_members.*.last_education'   => ['required', 'string', ValidationRule::in([
                    'TK/PAUD',
                    'SD/MI',
                    'SLTP/SMP/MTS',
                    'SLTA/SMA/MA/SMK',
                    'Diploma',
                    'S1',
                    'S2',
                    'S3',
                    'Belum/Tidak Sekolah',
                ])],
                'family_members.*.profession'       => ['nullable', 'string', 'min:2'],
            ],
            [
                'required'  => ':attribute :position wajib diisi.',
                'numeric'   => ':attribute :position harus berupa angka.',
                'string'    => ':attribute :position harus berupa string.',
                'family_members.*.nik_number.min'   => ':attribute :position harus setidaknya terdiri dari :min angka.',
                'min'       => ':attribute :position harus setidaknya terdiri dari :min karakter.',
            ],
            [
                'family_members.*.nik_number'       => 'No. NIK',
                'family_members.*.name'             => 'Nama',
                'family_members.*.birth_date'       => 'Tgl Lahir',
                'family_members.*.status'           => 'Status',
                'family_members.*.marital_status'   => 'Status Nikah',
                'family_members.*.gender'           => 'Jenis Kelamin',
                'family_members.*.last_education'   => 'Pendidikan Terakhir',
                'family_members.*.profession'       => 'Pekerjaan',
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
                $prefix . ':' . $areaName . ":fm:regencies:page-*:" . $dasawisma->regency_id,
                $prefix . ':' . $areaName . ":fm:districts:by-regency:" . $dasawisma->regency->slug . ":page-*:" . $dasawisma->district_id,
                $prefix . ':' . $areaName . ":fm:villages:by-district:" . $dasawisma->district->slug . ":page-*:" . $dasawisma->village_id,
                $prefix . ':' . $areaName . ":fm:dasawismas:by-village:" . $dasawisma->village->slug . ":page-*:" . $dasawisma->id,
                $prefix . ':' . $areaName . ":fm:family-heads:by-dasawisma:" . $dasawisma->slug . ":page-*:" . $this->family_head_id,
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

                        if (count($this->family_members) !== count($this->current_family_members)) {

                            // Get All New Data
                            $newFamilyMembers = array_slice($this->family_members, count($this->current_family_members));

                            // Jumlah Anggota Keluarga
                            $tx->hIncrBy($key, 'family_members_count', count($newFamilyMembers));

                            // Jenis Kelamin
                            $tx->hIncrBy($key, 'gender_males_count', $this->arrayCountVals($newFamilyMembers, 'gender', 'Laki-laki'));
                            $tx->hIncrBy($key, 'gender_females_count', $this->arrayCountVals($newFamilyMembers, 'gender', 'Perempuan'));

                            // Status Perkawinan
                            $tx->hIncrBy($key, 'marries_count', $this->arrayCountVals($newFamilyMembers, 'marital_status', 'Kawin'));
                            $tx->hIncrBy($key, 'singles_count', $this->arrayCountVals($newFamilyMembers, 'marital_status', 'Belum Kawin'));
                            $tx->hIncrBy($key, 'widows_count', $this->arrayCountVals($newFamilyMembers, 'marital_status', 'Janda'));
                            $tx->hIncrBy($key, 'widowers_count', $this->arrayCountVals($newFamilyMembers, 'marital_status', 'Duda'));

                            // Pendidikan Terakhir
                            $tx->hIncrBy($key, 'kindergartens_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'TK/PAUD'));
                            $tx->hIncrBy($key, 'elementary_schools_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'SD/MI'));
                            $tx->hIncrBy($key, 'middle_schools_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'SLTP/SMP/MTS'));
                            $tx->hIncrBy($key, 'high_schools_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'SLTA/SMA/MA/SMK'));
                            $tx->hIncrBy($key, 'associate_degrees_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'Diploma'));
                            $tx->hIncrBy($key, 'bachelor_degrees_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'S1'));
                            $tx->hIncrBy($key, 'master_degrees_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'S2'));
                            $tx->hIncrBy($key, 'post_degrees_count', $this->arrayCountVals($newFamilyMembers, 'last_education', 'S3'));

                            // Pekerjaan
                            $tx->hIncrBy($key, 'workings_count', count(array_filter(array_column($newFamilyMembers, 'profession'))));
                            $tx->hIncrBy($key, 'not_workings_count', array_count_values(array_column($newFamilyMembers, 'profession'))[''] ?? 0);
                        }

                        if (count($this->family_members) === count($this->current_family_members)) {

                            // Jenis Kelamin
                            $newGenders = array_diff_assoc(array_column($this->family_members, 'gender'), array_column($this->current_family_members, 'gender'));
                            if (!empty($newGenders)) {
                                $tx->hIncrBy($key, 'gender_males_count', array_count_values($newGenders)['Laki-laki'] ?? 0);
                                $tx->hIncrBy($key, 'gender_females_count', array_count_values($newGenders)['Perempuan'] ?? 0);
                            }
                            $removedGenders = array_diff_assoc(array_column($this->current_family_members, 'gender'), array_column($this->family_members, 'gender'));
                            if (!empty($removedGenders)) {
                                $tx->hIncrBy($key, 'gender_males_count', - (array_count_values($removedGenders)['Laki-laki'] ?? 0));
                                $tx->hIncrBy($key, 'gender_females_count', - (array_count_values($removedGenders)['Perempuan'] ?? 0));
                            }

                            // Status Perkawinan
                            $newMaritalStatuses = array_diff_assoc(array_column($this->family_members, 'marital_status'), array_column($this->current_family_members, 'marital_status'));
                            if (!empty($newMaritalStatuses)) {
                                $tx->hIncrBy($key, 'marries_count', array_count_values($newMaritalStatuses)['Kawin'] ?? 0);
                                $tx->hIncrBy($key, 'singles_count', array_count_values($newMaritalStatuses)['Belum Kawin'] ?? 0);
                                $tx->hIncrBy($key, 'widows_count', array_count_values($newMaritalStatuses)['Janda'] ?? 0);
                                $tx->hIncrBy($key, 'widowers_count', array_count_values($newMaritalStatuses)['Duda'] ?? 0);
                            }
                            $removedMaritalStatuses = array_diff_assoc(array_column($this->current_family_members, 'marital_status'), array_column($this->family_members, 'marital_status'));
                            if (!empty($removedMaritalStatuses)) {
                                $tx->hIncrBy($key, 'marries_count', - (array_count_values($removedMaritalStatuses)['Kawin'] ?? 0));
                                $tx->hIncrBy($key, 'singles_count', - (array_count_values($removedMaritalStatuses)['Belum Kawin'] ?? 0));
                                $tx->hIncrBy($key, 'widows_count', - (array_count_values($removedMaritalStatuses)['Janda'] ?? 0));
                                $tx->hIncrBy($key, 'widowers_count', - (array_count_values($removedMaritalStatuses)['Duda'] ?? 0));
                            }

                            // Pendidikan Terakhir
                            $newLastEducations = array_diff_assoc(array_column($this->family_members, 'last_education'), array_column($this->current_family_members, 'last_education'));
                            if (!empty($newLastEducations)) {
                                $tx->hIncrBy($key, 'kindergartens_count', array_count_values($newLastEducations)['TK/PAUD'] ?? 0);
                                $tx->hIncrBy($key, 'elementary_schools_count', array_count_values($newLastEducations)['SD/MI'] ?? 0);
                                $tx->hIncrBy($key, 'middle_schools_count', array_count_values($newLastEducations)['SLTP/SMP/MTS'] ?? 0);
                                $tx->hIncrBy($key, 'high_schools_count', array_count_values($newLastEducations)['SLTA/SMA/MA/SMK'] ?? 0);
                                $tx->hIncrBy($key, 'associate_degrees_count', array_count_values($newLastEducations)['Diploma'] ?? 0);
                                $tx->hIncrBy($key, 'bachelor_degrees_count', array_count_values($newLastEducations)['S1'] ?? 0);
                                $tx->hIncrBy($key, 'master_degrees_count', array_count_values($newLastEducations)['S2'] ?? 0);
                                $tx->hIncrBy($key, 'post_degrees_count', array_count_values($newLastEducations)['S3'] ?? 0);
                            }
                            $removedLastEducations = array_diff_assoc(array_column($this->current_family_members, 'last_education'), array_column($this->family_members, 'last_education'));
                            if (!empty($removedLastEducations)) {
                                $tx->hIncrBy($key, 'kindergartens_count', - (array_count_values($removedLastEducations)['TK/PAUD'] ?? 0));
                                $tx->hIncrBy($key, 'elementary_schools_count', - (array_count_values($removedLastEducations)['SD/MI'] ?? 0));
                                $tx->hIncrBy($key, 'middle_schools_count', - (array_count_values($removedLastEducations)['SLTP/SMP/MTS'] ?? 0));
                                $tx->hIncrBy($key, 'high_schools_count', - (array_count_values($removedLastEducations)['SLTA/SMA/MA/SMK'] ?? 0));
                                $tx->hIncrBy($key, 'associate_degrees_count', - (array_count_values($removedLastEducations)['Diploma'] ?? 0));
                                $tx->hIncrBy($key, 'bachelor_degrees_count', - (array_count_values($removedLastEducations)['S1'] ?? 0));
                                $tx->hIncrBy($key, 'master_degrees_count', - (array_count_values($removedLastEducations)['S2'] ?? 0));
                                $tx->hIncrBy($key, 'post_degrees_count', - (array_count_values($removedLastEducations)['S3'] ?? 0));
                            }

                            // Pekerjaan
                            $professions = array_diff_assoc(array_column($this->family_members, 'profession'), array_column($this->current_family_members, 'profession'));
                            if (!empty($professions)) {

                                $workingsCount = count(array_filter($professions, 'strlen'));

                                $notWorkingsCount = array_count_values($professions)[''] ?? 0;
                                $notWorkingsCount += array_count_values($professions)['Belum/Tidak Bekerja'] ?? 0;

                                if (!in_array('', $professions) && !in_array('Belum/Tidak Bekerja', $professions)) {
                                    $tx->hIncrBy($key, 'workings_count', $workingsCount ?? 0);
                                    $tx->hIncrBy($key, 'not_workings_count', - ($workingsCount ?? 0));
                                }

                                if (in_array('', $professions) || in_array('Belum/Tidak Bekerja', $professions)) {
                                    $tx->hIncrBy($key, 'not_workings_count', $notWorkingsCount ?? 0);
                                    $tx->hIncrBy($key, 'workings_count', - ($notWorkingsCount ?? 0));
                                }
                            }
                        }
                    }
                }
            });

            DB::transaction(function () {
                foreach ($this->family_members as $familyMember) {
                    if (isset($familyMember['id'])) {
                        $familyMemberExists = FamilyMember::query()
                            ->where('id', '=', $familyMember['id'])
                            ->first();
                        $familyMemberExists->family_head_id = $familyMember['family_head_id'];
                        $familyMemberExists->nik_number     = $familyMember['nik_number'];
                        $familyMemberExists->name           = str($familyMember['name'])->title();
                        $familyMemberExists->slug           = str($familyMember['name'])->slug();
                        $familyMemberExists->birth_date     = $familyMember['birth_date'];
                        $familyMemberExists->status         = $familyMember['status'];
                        $familyMemberExists->marital_status = $familyMember['marital_status'];
                        $familyMemberExists->gender         = $familyMember['gender'];
                        $familyMemberExists->last_education = $familyMember['last_education'];
                        $familyMemberExists->profession     = $familyMember['profession'] ?: 'Belum/Tidak Bekerja';
                        $familyMemberExists->save();

                        $familyHeadExists = FamilyHead::query()
                            ->where('id', '=', $familyMember['family_head_id'])
                            ->first();
                        $familyHeadExists->dasawisma_id  = $this->dasawisma_id;
                        $familyHeadExists->kk_number     = $this->kk_number;
                        $familyHeadExists->family_head   = str($this->family_head)->title();
                        $familyHeadExists->created_by    = auth()->id();
                        $familyHeadExists->save();
                    } else {
                        $familyMemberDoesntExists = new FamilyMember();
                        $familyMemberDoesntExists->family_head_id = $this->family_head_id;
                        $familyMemberDoesntExists->nik_number     = $familyMember['nik_number'];
                        $familyMemberDoesntExists->name           = str($familyMember['name'])->title();
                        $familyMemberDoesntExists->slug           = str($familyMember['name'])->slug();
                        $familyMemberDoesntExists->birth_date     = $familyMember['birth_date'];
                        $familyMemberDoesntExists->status         = $familyMember['status'];
                        $familyMemberDoesntExists->marital_status = $familyMember['marital_status'];
                        $familyMemberDoesntExists->gender         = $familyMember['gender'];
                        $familyMemberDoesntExists->last_education = $familyMember['last_education'];
                        $familyMemberDoesntExists->profession     = $familyMember['profession'] ?: 'Belum/Tidak Bekerja';
                        $familyMemberDoesntExists->save();
                    }
                }
            });

            toastr_success("Data Anggota Keluarga {$this->family_head} berhasil diperbarui!");
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }
}
