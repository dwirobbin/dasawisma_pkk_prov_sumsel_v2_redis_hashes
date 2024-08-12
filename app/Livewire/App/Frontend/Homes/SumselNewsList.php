<?php

namespace App\Livewire\App\Frontend\Homes;

use Livewire\Component;
use App\Models\SumselNews;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SumselNewsList extends Component
{
    public int $perData = 3;

    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';

    #[Computed()]
    public function sumselNews(): EloquentCollection|Collection
    {
        return SumselNews::query()
            ->select([
                'sumsel_news.id',
                'sumsel_news.title',
                'sumsel_news.slug',
                'sumsel_news.image',
                'sumsel_news.body',
                'sumsel_news.is_published',
                'sumsel_news.created_at',
                'users.name AS author',
                'users.username AS username',
            ])
            ->join('users', 'sumsel_news.author_id', '=', 'users.id')
            ->where('is_published', '=', true)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->take($this->perData)
            ->get();
    }

    public function render()
    {
        return view('livewire.app.frontend.homes.sumsel-news-list');
    }
}
