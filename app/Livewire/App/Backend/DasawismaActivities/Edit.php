<?php

namespace App\Livewire\App\Backend\DasawismaActivities;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DasawismaActivity;
use App\Livewire\Forms\DasawismaActivityArticleForm;
use Illuminate\Contracts\View\View;

class Edit extends Component
{
    use WithFileUploads;

    public DasawismaActivityArticleForm $form;

    public function mount(DasawismaActivity $dasawismaActivity): void
    {
        $this->form->setData($dasawismaActivity);
    }

    public function render(): View
    {
        return view('livewire.app.backend.dasawisma-activities.edit');
    }

    public function save(): void
    {
        $response = $this->form->store();

        flasher_message($response['message'], $response['type']);

        $this->redirectRoute('area.dasawisma_activity.index', navigate: true);
    }
}
