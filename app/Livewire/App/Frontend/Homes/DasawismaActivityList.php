<?php

namespace App\Livewire\App\Frontend\Homes;

use Livewire\Component;
use App\Models\DasawismaActivity;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class DasawismaActivityList extends Component
{
    public int $perData = 3;

    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';

    #[Computed()]
    public function dasawismaActivities(): EloquentCollection|Collection
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
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->take($this->perData)
            ->get();
    }

    public function render()
    {
        return view('livewire.app.frontend.homes.dasawisma-activity-list');
    }
}
