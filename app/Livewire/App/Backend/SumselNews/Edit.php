<?php

namespace App\Livewire\App\Backend\SumselNews;

use Livewire\Component;
use App\Models\SumselNews;
use Livewire\WithFileUploads;
use App\Livewire\Forms\SumselNewsArticleForm;
use Illuminate\Contracts\View\View;

class Edit extends Component
{
    use WithFileUploads;

    public SumselNewsArticleForm $form;

    public function mount(SumselNews $sumselNews): void
    {
        $this->form->setData($sumselNews);
    }

    public function render(): View
    {
        return view('livewire.app.backend.sumsel-news.edit');
    }

    public function save(): void
    {
        $response = $this->form->store();

        flasher_message($response['message'], $response['type']);

        $this->redirectRoute('area.sumsel_news.index', navigate: true);
    }
}
