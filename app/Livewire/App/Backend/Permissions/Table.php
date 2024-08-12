<?php

namespace App\Livewire\App\Backend\Permissions;

use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url]
    public string $search = '', $sortDirection = 'desc';

    public string $sortColumn = 'created_at';

    public function placeholder(): View
    {
        return view('placeholder');
    }

    #[Computed()]
    public function permissions(): Paginator
    {
        return Permission::query()
            ->select(['id', 'name', 'slug', 'created_at'])
            ->search(trim($this->search))
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[On('refresh-data')]
    public function render(): View
    {
        return view('livewire.app.backend.permissions.table');
    }
}
