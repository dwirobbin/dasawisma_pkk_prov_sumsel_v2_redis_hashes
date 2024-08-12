<?php

namespace App\Livewire\App\Backend\DasawismaActivities;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\DasawismaActivity;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

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
    public function dasawismaActivities(): Paginator
    {
        return DasawismaActivity::query()
            ->select([
                'dasawisma_activities.id',
                'dasawisma_activities.title',
                'dasawisma_activities.slug',
                'dasawisma_activities.image',
                'dasawisma_activities.is_published',
                'dasawisma_activities.created_at',
                'users.name AS author',
            ])
            ->join('users', 'dasawisma_activities.author_id', '=', 'users.id')
            ->search(trim($this->search))
            ->when(
                // prov
                auth()->user()->role_id == 2 && auth()->user()->admin->province_id != NULL && auth()->user()->admin->regency_id == NULL,
                function (Builder $query) {
                    $query
                        ->whereRelation('author', 'role_id', '=', 2)
                        ->whereRelation('author.admin', 'province_id', '!=', NULL);
                }
            )
            ->when(
                // kota
                auth()->user()->role_id == 2 && auth()->user()->admin->regency_id != NULL,
                function (Builder $query) {
                    $query
                        ->whereRelation('author', 'role_id', '=', 2)
                        ->whereRelation('author.admin', 'regency_id', '=', auth()->user()->admin->regency_id);
                }
            )
            ->when(
                // kecamatan
                auth()->user()->role_id == 2 && auth()->user()->admin->district_id != NULL,
                function (Builder $query) {
                    $query
                        ->whereRelation('author', 'role_id', '=', 2)
                        ->whereRelation('author.admin', 'district_id', '=', auth()->user()->admin->district_id);
                }
            )
            ->when(
                // kelurahan
                auth()->user()->role_id == 2 && auth()->user()->admin->village_id != NULL,
                function (Builder $query) {
                    $query
                        ->whereRelation('author', 'role_id', '=', 2)
                        ->whereRelation('author.admin', 'village_id', '=', auth()->user()->admin->village_id);
                }
            )
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate($this->perPage);
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
        return view('livewire.app.backend.dasawisma-activities.table');
    }
}
