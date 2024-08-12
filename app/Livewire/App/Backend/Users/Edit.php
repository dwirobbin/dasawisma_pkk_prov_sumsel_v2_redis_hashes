<?php

namespace App\Livewire\App\Backend\Users;

use Closure;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Edit extends Component
{
    use WithFileUploads;

    public ?User $user;
    public ?Admin $admin;

    public EloquentCollection|array $roles = [], $provinces = [], $regencies = [], $districts = [], $villages = [];

    public string|object|null $photo = null;
    public ?string $name = null, $username = null, $email = null, $phone_number = null, $role_id = null;
    public ?string $current_password = null, $new_password = null;
    public ?string $province_id = null, $regency_id = null, $district_id = null, $village_id = null;

    public function mount(User $user): void
    {
        $this->roles = Role::query()->get(['id', 'name']);
        $this->provinces = Province::query()->get(['id', 'name']);

        if ($user?->admin?->province()->exists()) {
            $this->regencies = Regency::query()
                ->where('province_id', '=', $user->admin->province_id)
                ->get(['id', 'name']);
        }

        if ($user?->admin?->regency()->exists()) {
            $this->districts = District::query()
                ->where('regency_id', '=', $user->admin->regency_id)
                ->get(['id', 'name']);
        }

        if ($user?->admin?->district()->exists()) {
            $this->villages = Village::query()
                ->where('district_id', '=', $user->admin->district_id)
                ->get(['id', 'name']);
        }

        $this->user = $user;
        $this->admin = $this->user?->admin;

        $this->photo = $user->photo;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->phone_number = $user?->admin?->phone_number;
        $this->province_id = $user?->admin?->province_id;
        $this->regency_id = $user?->admin?->regency_id;
        $this->district_id = $user?->admin?->district_id;
        $this->village_id = $user?->admin?->village_id;
    }

    public function updatedProvinceId(?string $provinceId): void
    {
        if (!empty($this->province_id) || !is_null($this->province_id)) {
            $this->regencies = Regency::query()
                ->where('province_id', '=', $provinceId)
                ->get(['id', 'name']);
            $this->district_id = $this->village_id = null;
        } else {
            $this->regencies = $this->districts = $this->villages = [];
        }
    }

    public function updatedRegencyId(?string $regencyId): void
    {
        if (!empty($this->regency_id) || !is_null($this->regency_id)) {
            $this->districts = District::query()
                ->where('regency_id', '=', $regencyId)
                ->get(['id', 'name']);
            $this->village_id = null;
        } else {
            $this->districts = $this->villages = [];
        }
    }

    public function updatedDistrictId(?string $districtId): void
    {
        if (!empty($this->district_id) || !is_null($this->district_id)) {
            $this->villages = Village::query()
                ->where('district_id', '=', $districtId)
                ->get(['id', 'name']);
        } else {
            $this->villages = [];
        }
    }

    public function render(): View
    {
        return view('livewire.app.backend.users.edit');
    }

    public function saveChange(): void
    {
        $validatedData = $this->validate([
            'name'              => 'required|string|min:3',
            'username'          => 'required|string|min:3|unique:users,username,' . $this->user->id,
            'email'             => 'required|email|unique:users,email,' . $this->user->id,
            'current_password'  => [
                'nullable',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        return $fail(__('Password yang anda berikan tidak cocok dengan :attribute.'));
                    }
                },
                'exclude'
            ],
            'new_password'      => [
                'nullable',
                ValidationRule::when(!empty($this->current_password), 'required|min:5'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (Hash::check($value, $this->user->password)) {
                        return $fail(__(':attribute tidak boleh sama dengan Kata sandi saat ini.'));
                    }
                },
            ],
            'phone_number'      => 'nullable|required_if:role_id,1,role_id,2|numeric',
            'photo'             => [
                'nullable',
                ValidationRule::when(is_object($this->photo), [
                    'image',
                    'mimes:jpg,jpeg,png,svg,gif',
                    'max:2048',
                    'unique:users,photo,' . $this->user->id
                ])
            ],
            'role_id'           => 'required|in:1,2,3',
            'province_id'       => 'nullable|required_if:role_id,2',
            'regency_id'        => 'nullable',
            'district_id'       => 'nullable',
            'village_id'        => 'nullable',
        ], [
            'required'              => ':attribute wajib diisi.',
            'required_if'           => ':attribute wajib diisi jika :other adalah SuperAdmin/Admin.',
            'nullable'              => ':attribute tidak wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'image'                 => ':attribute harus berupa file gambar.',
            'numeric'               => ':attribute harus berupa angka.',
            'min'                   => ':attribute minimal :min karakter.',
            'in'                    => ':attribute yang dipilih tidak valid.',
            'photo.max'             => 'Maksimal size :attribute 2 MB.',
            'mimes'                 => ':attribute harus berformat :values.',
            'unique'                => ':attribute sudah digunakan.',
        ], [
            'name'                  => 'Nama',
            'username'              => 'Username',
            'email'                 => 'Email',
            'current_password'      => 'Password saat ini',
            'new_password'          => 'Password baru',
            'phone_number'          => 'No. Telepon',
            'photo'                 => 'Foto profil',
            'role_id'               => 'Role',
            'province_id'           => 'Provinsi',
        ]);

        try {
            if (is_object($validatedData['photo'])) {
                $filePath = 'image/profiles';

                if (Storage::disk('public')->exists($filePath . '/' . $this->user->getRawOriginal('photo'))) {
                    Storage::disk('public')->delete($filePath . '/' . $this->user->getRawOriginal('photo'));
                };

                $newFile = $this->photo->store($filePath, 'public');
                $validatedData['photo'] = str_replace("$filePath/", '', $newFile);
            } else {
                $validatedData['photo'] = $this->user->getRawOriginal('photo');
            }

            $validatedData['new_password'] = match (true) {
                !empty($validatedData['new_password']) => Hash::make($validatedData['new_password']),
                default => $this->user->password,
            };

            DB::transaction(function () use ($validatedData) {
                $this->user->update([
                    'name'          => str($validatedData['name'])->title(),
                    'username'      => $validatedData['username'],
                    'email'         => $validatedData['email'],
                    'password'      => $validatedData['new_password'],
                    'photo'         => $validatedData['photo'],
                    'role_id'       => $validatedData['role_id'],
                ]);

                $this->user?->admin()->update([
                    'phone_number'  => $validatedData['phone_number'],
                    'province_id'   => $validatedData['province_id'],
                    'regency_id'    => $validatedData['regency_id'],
                    'district_id'   => $validatedData['district_id'],
                    'village_id'    => $validatedData['village_id'],
                ]);
            });

            flasher_success('Data berhasil diperbaharui.');
        } catch (\Throwable) {
            flasher_fail('Terjadi suatu kesalahan.');
        }

        $this->redirectRoute('area.users.index', navigate: true);
    }
}
