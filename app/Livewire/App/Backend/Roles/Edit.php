<?php

namespace App\Livewire\App\Backend\Roles;

use App\Models\Role;
use Livewire\Component;
use App\Livewire\Forms\RoleForm;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class Edit extends Component
{
    public RoleForm $form;
    public array $permissionTitles = [];

    public function mount(Role $role, array $permissionTitles): void
    {
        $this->permissionTitles = $permissionTitles;
        $this->form->setData($role);
    }

    #[On('refresh-data')]
    public function render(): View
    {
        return view('livewire.app.backend.roles.edit');
    }

    public function saveChange(): void
    {
        $response = $this->form->store();

        flasher_message($response['message'], $response['type']);

        $this->redirectRoute('area.roles.index', navigate: true);
    }
}
