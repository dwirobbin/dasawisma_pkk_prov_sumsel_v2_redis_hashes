<?php

namespace App\Livewire\App\Bootstraps;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleButton extends Component
{
    public Model $model;
    public string $field;

    public bool $isTrue;

    public function mount(): void
    {
        $this->isTrue = (bool) $this->model->getAttribute($this->field);
    }

    public function render(): View
    {
        return view('livewire.app.bootstraps.toggle-button');
    }

    public function updating($field, $value): void
    {
        try {
            $this->model->setAttribute($this->field, $value)->save();

            flasher_success(!$this->isTrue ? 'Status Akun: Aktif' : 'Status Akun: Tidak Aktif');
        } catch (\Throwable $th) {
            flasher_fail('Terjadi suatu kesalahan.');
        }
    }
}
