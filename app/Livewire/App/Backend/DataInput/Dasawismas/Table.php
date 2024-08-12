<?php

namespace App\Livewire\App\Backend\DataInput\Dasawismas;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
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

    public string $sortColumn = 'dsw.created_at';

    public Collection|array $provinces = [], $regencies = [], $districts = [], $villages = [];
    public ?string $provinceId = null, $regencyId = null, $districtId = null, $villageId = null;

    public function mount()
    {
        $this->provinces = Province::query()->select('id', 'name')->get();
    }

    #[Computed()]
    public function dasawismas(): Paginator
    {
        return Dasawisma::query()
            ->from('dasawismas AS dsw')
            ->selectRaw("
                dsw.id, dsw.name, dsw.slug, dsw.rt, dsw.rw, dsw.province_id, dsw.regency_id, dsw.district_id, dsw.village_id,
                CONCAT_WS(', ', p.name, r.name, d.name, v.name) AS area
            ")
            ->join('provinces AS p', 'dsw.province_id', '=', 'p.id')
            ->join('regencies AS r', 'dsw.regency_id', '=', 'r.id')
            ->join('districts AS d', 'dsw.district_id', '=', 'd.id')
            ->join('villages AS v', 'dsw.village_id', '=', 'v.id')
            ->when($this->search != '', fn(Builder $query) => $query->search(trim($this->search)))
            ->when($this->provinceId != '', fn(Builder $query) => $query->where('dsw.province_id', 'LIKE', "%{$this->provinceId}%"))
            ->when($this->regencyId != '', fn(Builder $query) => $query->where('dsw.regency_id', '=', $this->regencyId))
            ->when($this->districtId != '', fn(Builder $query) => $query->where('dsw.district_id', 'LIKE', "%{$this->districtId}%"))
            ->when($this->villageId != '', fn(Builder $query) => $query->where('dsw.village_id', 'LIKE', "%{$this->villageId}%"))
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

    public function placeholder(): View
    {
        return view('placeholder');
    }

    public function updatedSearch()
    {
        $this->resetExcept('provinces', 'search', 'sortDirection', 'sortColumn');
        $this->resetPage();
    }

    public function updatedProvinceId(?string $provinceId)
    {
        if ($this->provinceId != '') {
            if (auth()->user()->admin->regency_id != null) {
                $this->regencies = Regency::query()
                    ->select(['id', 'name'])
                    ->where('province_id', '=', $provinceId)
                    ->where('id', '=', auth()->user()->admin->regency_id)
                    ->get();
            } else {
                $this->regencies = Regency::query()
                    ->select(['id', 'name'])
                    ->where('province_id', '=', $provinceId)
                    ->get();
            }

            $this->reset('districtId', 'villageId', 'search');
        } else {
            $this->resetExcept('provinces', 'search');
        }
    }

    public function updatedRegencyId(?string $regencyId)
    {
        if ($this->regencyId != '') {
            if (auth()->user()->admin->district_id != null) {
                $this->districts = District::query()
                    ->select(['id', 'name'])
                    ->where('regency_id', '=', $regencyId)
                    ->where('id', '=', auth()->user()->admin->district_id)
                    ->get();
            } else {
                $this->districts = District::query()
                    ->select(['id', 'name'])
                    ->where('regency_id', '=', $regencyId)
                    ->get();
            }

            $this->reset('villageId', 'search');
        } else {
            $this->reset('regencyId', 'districts', 'districtId', 'villages', 'villageId');
        }
    }

    public function updatedDistrictId(?string $districtId)
    {
        if ($this->districtId != '') {
            if (auth()->user()->admin->village_id != null) {
                $this->villages = Village::query()
                    ->select(['id', 'name'])
                    ->where('district_id', '=', $districtId)
                    ->where('id', '=', auth()->user()->admin->village_id)
                    ->get();
            } else {
                $this->villages = Village::query()
                    ->select(['id', 'name'])
                    ->where('district_id', '=', $districtId)
                    ->get();
            }
        } else {
            $this->reset('districtId', 'villages', 'villageId');
        }
    }

    #[On('refresh-data')]
    public function render()
    {
        return view('livewire.app.backend.data-input.dasawismas.table');
    }
}
