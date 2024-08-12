<?php

namespace App\Livewire\Forms;

use App\Models\Permission;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rule as ValidationRule;

class PermissionForm extends Form
{
    public ?Permission $permission = NULL;

    public ?string $name = NULL;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3',
                ValidationRule::when(!is_null($this->permission), ValidationRule::unique('permissions', 'name')->ignore($this->permission?->id, 'id')),
                ValidationRule::when(is_null($this->permission), ValidationRule::unique('permissions', 'name')),
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
            'name' => 'Nama Permission',
        ];
    }

    public function setData(string $slug): void
    {
        $this->permission = Permission::where('slug', '=', $slug)->firstOrFail();
        $this->name = $this->permission->name;
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        try {
            if (is_null($this->permission)) {

                Permission::query()->create(array_merge([
                    'slug' => str($validatedData['name'])->slug()
                ], $validatedData));

                $this->message = 'Permission berhasil ditambahkan!';
            }

            if (!is_null($this->permission)) {

                $this->permission->update(array_merge([
                    'slug' => str($validatedData['name'])->slug()
                ], $validatedData));

                $this->message = 'Permission berhasil diperbaharui!';
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
        $this->clearValidation();
    }

    public function resetData(): void
    {
        $this->name = $this->permission->name;
        $this->clearValidation();
    }
}
