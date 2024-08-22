<?php

namespace App\Livewire\App\Backend\Permissions;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\PermissionForm;
use App\Livewire\App\Backend\Permissions\Table;
use Illuminate\Contracts\View\View;

class Form extends Component
{
    public bool $isUpdate = false;

    public PermissionForm $form;

    public function render(): View
    {
        return view('livewire.app.backend.permissions.form');
    }

    #[On('set-data')]
    public function edit(string $slug): void
    {
        $this->form->setData($slug);
        $this->isUpdate = true;

        $this->clearValidation();
    }

    public function save(): void
    {
        $this->isUpdate = (is_null($this->form->permission)) ? false : true;

        $response = $this->form->store();

        toastr_message($response['message'], $response['type']);

        $this->isUpdate = (is_null($this->form->permission)) ? false : true;

        $this->dispatch('refresh-data')->to(Table::class);
    }

    public function resetForm(): void
    {
        if ($this->isUpdate) {
            $this->form->resetData();
        } else {
            $this->form->clearForm();
            $this->isUpdate = false;
            $this->dispatch('refresh-data')->to(Table::class);
        }
    }
}
