<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilySizeMembers;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\FamilySizeMember;
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

    public string $sortColumn = 'fsm.created_at';

    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];

    public function placeholder(): View
    {
        return view('placeholder');
    }

    #[Computed()]
    public function familySizeMembers(): Paginator
    {
        return FamilySizeMember::from('family_size_members AS fsm')
            ->selectRaw("
                fsm.id,
                IF(dsw.name IS NULL, 'Belum di set', dsw.name) AS dasawisma_name,
                fh.family_head, fh.kk_number,
                IF(fh.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', p.name, r.name, d.name, v.name)) AS area,
                fsm.toddlers_number, fsm.pus_number, fsm.wus_number,
                fsm.blind_people_number, fsm.pregnant_women_number,
                fsm.breastfeeding_mother_number, fsm.elderly_number
            ")
            ->leftJoin('family_heads AS fh', 'fsm.family_head_id', '=', 'fh.id')
            ->leftJoin('dasawismas AS dsw', 'fh.dasawisma_id', '=', 'dsw.id')
            ->leftJoin('provinces AS p', 'dsw.province_id', '=', 'p.id')
            ->leftJoin('regencies AS r', 'dsw.regency_id', '=', 'r.id')
            ->leftJoin('districts AS d', 'dsw.district_id', '=', 'd.id')
            ->leftJoin('villages AS v', 'dsw.village_id', '=', 'v.id')
            ->when($this->search != '',  function (Builder $query) {
                $query->where('dsw.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('p.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('r.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('d.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('v.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('fh.family_head', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.toddlers_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.pus_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.wus_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.blind_people_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.pregnant_women_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.breastfeeding_mother_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('fsm.elderly_number', 'LIKE', "%{$this->search}%");
            })
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
        return view('livewire.app.backend.data-input.members.family-size-members.table');
    }
}
