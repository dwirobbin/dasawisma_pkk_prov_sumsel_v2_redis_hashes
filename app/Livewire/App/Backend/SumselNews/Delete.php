<?php

namespace App\Livewire\App\Backend\SumselNews;

use Livewire\Component;
use App\Models\SumselNews;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\File;
use App\Livewire\App\Backend\SumselNews\Table;
use Illuminate\Contracts\View\View;

class Delete extends Component
{
    #[Locked]
    public int $id;

    #[On('delete-confirm')]
    public function setData(int $id, string $title): void
    {
        $this->id = $id;

        $this->dispatch('show-modal-confirm', id: $id, title: $title);
    }

    public function render(): View
    {
        return view('livewire.app.backend.sumsel-news.delete');
    }

    public function delete(): void
    {
        try {
            $sumselNews = SumselNews::findOrFail($this->id);

            $path = 'storage/image/sumsel-news/';
            $image = '';
            if (str_contains($sumselNews->image, 'sumsel-news')) {
                $image = str_replace(url("/$path") . "/", '', $sumselNews->image);
            }

            $isSuccess = $sumselNews->delete();

            if ($isSuccess) {
                $dest = public_path($path);
                if (File::exists($dest . $image)) File::delete($dest . $image);
            }

            toastr_success('Data berhasil dihapus.');

            $this->dispatch('refresh-data')->to(Table::class);
        } catch (\Exception) {
            toastr_error('Terjadi suatu kesalahan.');
        }
    }
}
