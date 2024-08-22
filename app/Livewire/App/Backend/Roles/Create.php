<?php

namespace App\Livewire\App\Backend\Roles;

use Livewire\Component;
use App\Livewire\Forms\RoleForm;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

class Create extends Component
{
    public RoleForm $form;

    #[Computed()]
    public function permissionTitles()
    {
        return Permission::query()
            ->select('id', 'title', 'name', 'slug')
            ->get()
            ->groupBy('title');
    }

    public function render(): View
    {
        return view('livewire.app.backend.roles.create');
    }

    public function save(): void
    {
        $response = $this->form->store();

        toastr_message($response['message'], $response['type']);

        $this->redirectRoute('area.roles.index', navigate: true);
    }

    public function clear(): void
    {
        $this->form->clearForm();

        $this->clearValidation();

        toastr_success('Form Berhasil direset.');
    }
}
