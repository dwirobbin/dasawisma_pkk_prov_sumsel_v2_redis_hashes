<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyMembers;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyHead;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
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

            flasher_success("Data Anggota Keluarga {$this->family_head} berhasil diperbarui!");
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->redirect(route('area.data-input.member.index'), true);
    }
}
