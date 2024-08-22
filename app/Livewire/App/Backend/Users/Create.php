<?php

namespace App\Livewire\App\Backend\Users;

use App\Models\Role;
use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Create extends Component
{
    use WithFileUploads;

    public EloquentCollection|array $roles = [], $provinces = [], $regencies = [], $districts = [], $villages = [];

    public string|object|null $photo = null;
    public ?string $name = null, $username = null, $email = null, $phone_number = null, $role_id = null;
    public ?string $password = null, $password_confirmation = null;
    public ?string $province_id = null, $regency_id = null, $district_id = null, $village_id = null;

    public function mount(): void
    {
        $this->roles = Role::query()->get(['id', 'name']);
        $this->provinces = Province::query()->get(['id', 'name']);
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
        return view('livewire.app.backend.users.create');
    }

    public function save(): void
    {
        $validatedData = $this->validate([
            'name'                  => 'required|string|min:3',
            'username'              => 'required|string|min:3|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:5',
            'password_confirmation' => 'required|min:5|same:password|exclude',
            'phone_number'          => 'nullable|required_if:role_id,1,role_id,2|numeric',
            'photo'                 => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048|unique:users,photo',
            'role_id'               => 'required|in:1,2,3',
            'province_id'           => 'nullable|required_if:role_id,1,role_id,2',
            'regency_id'            => 'nullable',
            'district_id'           => 'nullable',
            'village_id'            => 'nullable',
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
            'same'                  => ':attribute harus sama dengan :other.',
        ], [
            'name'                  => 'Nama',
            'username'              => 'Username',
            'email'                 => 'Email',
            'password'              => 'Password',
            'password_confirmation' => 'Password Konfirmasi',
            'phone_number'          => 'No. Telepon',
            'photo'                 => 'Foto Profil',
            'role_id'               => 'Role',
            'province_id'           => 'Provinsi',
        ]);

        try {
            if (is_object($validatedData['photo'])) {
                $pathImg = 'image/profiles';
                $imgName = $this->photo->store($pathImg, 'public');
                $validatedData['photo'] = str_replace("$pathImg/", '', $imgName);
            }

            DB::transaction(function () use ($validatedData) {
                $user = User::create([
                    'name'          => str($validatedData['name'])->title(),
                    'username'      => $validatedData['username'],
                    'email'         => $validatedData['email'],
                    'password'      => Hash::make($validatedData['password']),
                    'photo'         => $validatedData['photo'],
                    'role_id'       => $validatedData['role_id'],
                ]);

                $user->admin()->create([
                    'phone_number'  => $validatedData['phone_number'],
                    'province_id'   => $validatedData['province_id'],
                    'regency_id'    => $validatedData['regency_id'],
                    'district_id'   => $validatedData['district_id'],
                    'village_id'    => $validatedData['village_id'],
                ]);
            });

            toastr_success('User baru berhasil ditambahkan.');
        } catch (\Throwable) {
            toastr_error('Terjadi suatu kesalahan.');
        }

        $this->redirectRoute('area.users.index', navigate: true);
    }
}
