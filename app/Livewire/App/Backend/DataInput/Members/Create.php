<?php

namespace App\Livewire\App\Backend\DataInput\Members;

use Livewire\Component;
use App\Models\Dasawisma;
use Illuminate\View\View;
use App\Models\FamilyHead;
use App\Models\FamilyMember;
use App\Models\FamilyActivity;
use App\Models\FamilyBuilding;
use App\Models\FamilySizeMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Create extends Component
{
    public ?EloquentCollection $dasawismas = NULL;

    public int $currentStep = 1;

    // step1 properties
    public ?string $dasawisma_id = NULL, $kk_number = NULL, $family_head = NULL;

    // step2 properties
    public array $water_src = [];
    public ?string $staple_food = NULL, $house_criteria = NULL;
    public ?string $have_toilet = NULL, $have_landfill = NULL, $have_sewerage = NULL, $pasting_p4k_sticker = NULL;

    // step3 properties
    public ?int $toddlers_number = NULL, $pus_number = NULL, $wus_number = NULL, $blind_people_number = NULL;
    public ?int $pregnant_women_number = NULL, $breastfeeding_mother_number = NULL, $elderly_number = NULL;

    // step4 properties
    public array $family_members = [];

    // step5 properties
    public array $up2k_activities = [], $env_health_activities = [];

    public function mount()
    {
        $this->dasawismas = Dasawisma::query()->select('id', 'name')->get();

        $this->family_members = [[
            'nik_number'        => '',
            'name'              => '',
            'birth_date'        => '',
            'status'            => '',
            'marital_status'    => '',
            'gender'            => '',
            'last_education'    => '',
            'profession'        => '',
        ]];

        $this->up2k_activities = [[
            'name'        => '',
        ]];

        $this->env_health_activities = [[
            'name'        => '',
        ]];
    }

    public function placeholder(): View
    {
        return view('placeholder');
    }

    public function updatedFamilyHead()
    {
        $this->family_members[0]['name'] = (string) str($this->family_head)->title();
        $this->family_members[0]['status'] = 'Kepala Keluarga';
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.members.create');
    }

    public function firstStepSubmit()
    {
        $this->validate(
            [
                'dasawisma_id'  => ['nullable', 'string', ValidationRule::in($this->dasawismas->pluck('id')->toArray())],
                'kk_number'     => ['required', 'numeric', 'min:16', 'unique:family_heads,kk_number'],
                'family_head'   => ['required', 'string', 'min:3'],
            ],
            [
                'required'      => ':attribute wajib diisi.',
                'string'        => ':attribute harus berupa string.',
                'numeric'       => ':attribute harus berupa angka.',
                'min'           => ':attribute harus setidaknya terdiri dari :min karakter.',
                'kk_number.min' => ':attribute harus setidaknya terdiri dari :min angka.',
                'in'            => ':attribute yang dipilih tidak valid.',
            ],
            [
                'dasawisma_id'  => 'Dasawisma',
                'kk_number'     => 'No. KK',
                'family_head'   => 'Nama Kepala Keluarga',
            ]
        );

        $this->currentStep = 2;
    }

    public function secondStepSubmit()
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

        $this->currentStep = 3;
    }

    public function thirdStepSubmit()
    {
        $this->validate(
            [
                'toddlers_number'               => ['nullable', 'numeric', 'integer'],
                'pus_number'                    => ['nullable', 'numeric', 'integer'],
                'wus_number'                    => ['nullable', 'numeric', 'integer'],
                'blind_people_number'           => ['nullable', 'numeric', 'integer'],
                'pregnant_women_number'         => ['nullable', 'numeric', 'integer'],
                'breastfeeding_mother_number'   => ['nullable', 'numeric', 'integer'],
                'elderly_number'                => ['nullable', 'numeric', 'integer'],
            ],
            [
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

        $this->currentStep = 4;
    }

    public function forthStepSubmit()
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

        $this->currentStep = 5;
    }

    public function save()
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
            DB::transaction(function () {
                $familyHead = FamilyHead::query()
                    ->create([
                        'dasawisma_id'  => $this->dasawisma_id,
                        'kk_number'     => $this->kk_number,
                        'family_head'   => str($this->family_head)->title(),
                        'created_by'    => auth()->id(),
                    ]);

                FamilyBuilding::query()
                    ->create([
                        'family_head_id'        => $familyHead->id,
                        'staple_food'           => $this->staple_food,
                        'have_toilet'           => ($this->have_toilet === 'yes') ? true : false,
                        'water_src'             => implode(',', (array) $this->water_src),
                        'have_landfill'         => ($this->have_landfill === 'yes') ? true : false,
                        'have_sewerage'         => ($this->have_sewerage === 'yes') ? true : false,
                        'pasting_p4k_sticker'   => ($this->pasting_p4k_sticker === 'yes') ? true : false,
                        'house_criteria'        => $this->house_criteria,
                    ]);

                FamilySizeMember::query()
                    ->create([
                        'family_head_id'                => $familyHead->id,
                        'toddlers_number'               => $this->toddlers_number ?? 0,
                        'pus_number'                    => $this->pus_number ?? 0,
                        'wus_number'                    => $this->wus_number ?? 0,
                        'blind_people_number'           => $this->blind_people_number ?? 0,
                        'pregnant_women_number'         => $this->pregnant_women_number ?? 0,
                        'breastfeeding_mother_number'   => $this->breastfeeding_mother_number ?? 0,
                        'elderly_number'                => $this->elderly_number ?? 0,
                    ]);

                foreach ($this->family_members as $familyMember) {
                    $newFamilyMember = new FamilyMember();
                    $newFamilyMember->family_head_id = $familyHead->id;
                    $newFamilyMember->nik_number     = $familyMember['nik_number'];
                    $newFamilyMember->name           = $familyMember['name'];
                    $newFamilyMember->slug           = str($familyMember['name'])->slug();
                    $newFamilyMember->birth_date     = $familyMember['birth_date'];
                    $newFamilyMember->status         = $familyMember['status'];
                    $newFamilyMember->marital_status = $familyMember['marital_status'];
                    $newFamilyMember->gender         = $familyMember['gender'];
                    $newFamilyMember->last_education = $familyMember['last_education'];
                    $newFamilyMember->profession     = $familyMember['profession'];
                    $newFamilyMember->save();
                }

                FamilyActivity::query()
                    ->create([
                        'family_head_id'        => $familyHead->id,
                        'up2k_activity'         => $this->multiImplode($this->up2k_activities, ','),
                        'env_health_activity'   => $this->multiImplode($this->env_health_activities, ','),
                    ]);
            });

            toastr_success('Data berhasil ditambahkan.');
        } catch (\Throwable) {
            $this->reset();
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

    public function back($step)
    {
        $this->currentStep = $step;
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
}
