<?php

namespace App\Livewire\App\Frontend\SumselNews;

use Livewire\Component;
use App\Models\SumselNews;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
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
    public function sumselNews(): LengthAwarePaginator|Collection
    {
        return SumselNews::query()
            ->select([
                'sumsel_news.id',
                'sumsel_news.title',
                'sumsel_news.slug',
                'sumsel_news.image',
                'sumsel_news.is_published',
                'sumsel_news.created_at',
                'users.name AS author',
                'users.username AS username',
            ])
            ->join('users', 'sumsel_news.author_id', '=', 'users.id')
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
        return view('livewire.app.frontend.sumsel-news.list-data');
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
