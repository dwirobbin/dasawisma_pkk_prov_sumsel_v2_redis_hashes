<?php

namespace App\Livewire\Forms;

use App\Models\Permission;
use Livewire\Form;
use App\Models\Role;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule as ValidationRule;

class RoleForm extends Form
{
    public ?Role $role = NULL;

    public ?string $name = NULL;
    public array $permissions = [];

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3',
                ValidationRule::when(!is_null($this->role), ValidationRule::unique('roles', 'name')->ignore($this->role?->id, 'id')),
                ValidationRule::when(is_null($this->role), ValidationRule::unique('roles', 'name')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            '*.unique' => ':attribute sudah ada.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'Nama Role',
        ];
    }

    public function setData(Role $role): void
    {
        $this->role = $role;
        $this->name = $this->role->name;

        array_push($this->permissions, ...$role->permissions->pluck('slug')->toArray());
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        try {
            if (is_null($this->role)) {
                DB::transaction(function () use ($validatedData) {
                    $role = Role::query()->create(array_merge([
                        'slug' => str($validatedData['name'])->slug()
                    ], $validatedData));

                    Permission::query()
                        ->whereIn('slug', $this->permissions)
                        ->get()
                        ->map(fn ($permision) => $role->permissions()->attach($permision->id));
                });

                $this->message = 'Role berhasil ditambahkan!';
            }

            if (!is_null($this->role)) {
                DB::transaction(function () use ($validatedData) {
                    $this->role->update(array_merge([
                        'slug' => str($validatedData['name'])->slug()
                    ], $validatedData));

                    $permisionIDs = Permission::query()
                        ->whereIn('slug', $this->permissions)
                        ->pluck('id')
                        ->toArray();

                    $this->role->permissions()->sync($permisionIDs);
                });

                $this->message = 'Role berhasil diperbaharui!';
            }

            $this->response = ['type' => 'success', 'message' => $this->message];
        } catch (\Throwable) {
            $this->response = ['type' => 'error', 'message' => 'Terjadi suatu kesalahan!!'];
        } finally {
            $this->reset();
        }

        return $this->response;
    }

    public function clearForm(): void
    {
        $this->reset('name');
    }

    public function resetData(): void
    {
        $this->name = $this->role->name;
    }
}
