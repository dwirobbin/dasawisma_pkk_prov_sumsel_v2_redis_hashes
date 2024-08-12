<?php

namespace App\Livewire\App\Backend\SumselNews;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\SumselNewsArticleForm;
use Illuminate\Contracts\View\View;

class Create extends Component
{
    use WithFileUploads;

    public SumselNewsArticleForm $form;

    public function render(): View
    {
        return view('livewire.app.backend.sumsel-news.create');
    }

    public function save(): void
    {
        $response = $this->form->store();

        flasher_message($response['message'], $response['type']);

        $this->redirectRoute('area.sumsel_news.index', navigate: true);
    }
}
