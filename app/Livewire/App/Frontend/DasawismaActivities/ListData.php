<?php

namespace App\Livewire\App\Frontend\DasawismaActivities;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\DasawismaActivity;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListData extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 3;

    #[Url]
    public string $search = '', $sortDirection = 'desc', $author = '';

    public string $sortColumn = 'created_at';

    #[Computed()]
    public function dasawismaActivities(): LengthAwarePaginator|Collection
    {
        return DasawismaActivity::query()
            ->select([
                'dasawisma_activities.id',
                'dasawisma_activities.title',
                'dasawisma_activities.slug',
                'dasawisma_activities.image',
                'dasawisma_activities.body',
                'dasawisma_activities.is_published',
                'dasawisma_activities.created_at',
                'users.name AS author',
                'users.username AS username',
            ])
            ->join('users', 'dasawisma_activities.author_id', '=', 'users.id')
            ->where('is_published', '=', true)
            ->when($this->author != '', fn (Builder $query) => $query->where('users.username', '=', $this->author))
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

    public function render()
    {
        return view('livewire.app.frontend.dasawisma-activities.list-data');
    }

    public function paginationView(): string
    {
        return 'paginations.custom-pagination-links';
    }

    public function setSort(string $sortDirection)
    {
        $this->sortDirection = ($sortDirection === 'desc') ? 'desc' : 'asc';
    }

    public function clearFilters()
    {
        $this->reset(['search', 'author']);

        $this->resetPage();
    }
}
