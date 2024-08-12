<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyHeads;

use Livewire\Component;
use App\Models\FamilyHead;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url()]
    public string $search = '', $sortDirection = 'desc';

    public string $sortColumn = 'fh.created_at';

    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];

    public function placeholder(): View
    {
        return view('placeholder');
    }

    #[Computed()]
    public function familyHeads(): Paginator
    {
        return FamilyHead::from('family_heads AS fh')
            ->selectRaw("
                fh.id,
                IF(dsw.name IS NULL, 'Belum di set', dsw.name) AS dasawisma_name,
                fh.kk_number, fh.family_head,
                IF(fh.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', p.name, r.name, d.name, v.name)) AS area
            ")
            ->leftJoin('dasawismas AS dsw', 'fh.dasawisma_id', '=', 'dsw.id')
            ->leftJoin('provinces AS p', 'dsw.province_id', '=', 'p.id')
            ->leftJoin('regencies AS r', 'dsw.regency_id', '=', 'r.id')
            ->leftJoin('districts AS d', 'dsw.district_id', '=', 'd.id')
            ->leftJoin('villages AS v', 'dsw.village_id', '=', 'v.id')
            ->when($this->search != '', fn(Builder $query) => $query->search(trim($this->search)))
            ->when(
                auth()->user()->role_id == 2 && auth()->user()->admin->district_id != NULL
                    && (auth()->user()->admin->village_id == NULL || auth()->user()->admin->village_id != NULL),
                function (Builder $query) {
                    $query->where('d.id', '=', auth()->user()->admin->district_id)
                        ->orWhere('v.id', '=', auth()->user()->admin->village_id);
                }
            )
            ->when(
                auth()->user()->role_id == 2 && auth()->user()->admin->regency_id != NULL,
                function (Builder $query) {
                    $query->where('r.id', '=', auth()->user()->admin->regency_id);
                }
            )
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate($this->perPage);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-data')]
    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-heads.table');
    }
}
