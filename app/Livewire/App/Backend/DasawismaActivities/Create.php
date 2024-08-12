<?php

namespace App\Livewire\App\Backend\DasawismaActivities;

use App\Livewire\Forms\DasawismaActivityArticleForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public DasawismaActivityArticleForm $form;

    public function render(): View
    {
        return view('livewire.app.backend.dasawisma-activities.create');
    }

    public function save(): void
    {
        $response = $this->form->store();

        flasher_message($response['message'], $response['type']);

        $this->redirectRoute('area.dasawisma_activity.index', navigate: true);
    }
}
