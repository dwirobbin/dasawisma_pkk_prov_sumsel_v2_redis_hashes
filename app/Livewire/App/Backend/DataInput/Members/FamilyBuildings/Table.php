<?php

namespace App\Livewire\App\Backend\DataInput\Members\FamilyBuildings;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\FamilyBuilding;
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

    public string $sortColumn = 'fb.created_at';

    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];

    public function placeholder(): View
    {
        return view('placeholder');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function familyBuildings(): Paginator
    {
        return FamilyBuilding::from('family_buildings AS fb')
            ->selectRaw("
                fb.id,
                IF(dsw.name IS NULL, 'Belum di set', dsw.name) AS dasawisma_name,
                fh.kk_number, fh.family_head,
                fb.staple_food,
                IF(fh.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', p.name, r.name, d.name, v.name)) AS area,
                (CASE WHEN (fb.have_toilet = 1) THEN 'Ya' ELSE 'Tidak' END) as have_toilet,
                fb.water_src,
                (CASE WHEN (fb.have_landfill = 1) THEN 'Ya' ELSE 'Tidak' END) as have_landfill,
                (CASE WHEN (fb.have_sewerage = 1) THEN 'Ya' ELSE 'Tidak' END) as have_sewerage,
                (CASE WHEN (fb.pasting_p4k_sticker = 1) THEN 'Ya' ELSE 'Tidak' END) as pasting_p4k_sticker,
                fb.house_criteria
            ")
            ->leftJoin('family_heads AS fh', 'fb.family_head_id', '=', 'fh.id')
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
                    ->orWhere('fb.staple_food', 'LIKE', "%{$this->search}%")
                    ->orWhere('fb.water_src', 'LIKE', "%{$this->search}%")
                    ->orWhere('fb.house_criteria', 'LIKE', "%{$this->search}%");
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-data')]
    public function render()
    {
        return view('livewire.app.backend.data-input.members.family-buildings.table');
    }
}
