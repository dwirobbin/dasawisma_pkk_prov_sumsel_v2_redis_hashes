<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SumselNews;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SumselNewsController extends Controller
{
    public function index(): View
    {
        return view('pages.frontend.sumsel-news.index');
    }

    public function show(SumselNews $sumselNews): View
    {
        $moreArticles = SumselNews::query()
            ->select(['title', 'slug', 'image', 'body', 'created_at'])
            ->where([
                ['id', '!=', $sumselNews->id],
                ['is_published', '=', true],
            ])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $moreAuthors = User::query()
            ->select(['name', 'username'])
            ->withWhereHas('sumselNews', fn (Builder $query) => $query
                ->where([
                    ['author_id', '!=', $sumselNews->author_id],
                    ['is_published', '=', true],
                ]))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.frontend.sumsel-news.show', [
            'sumselNews' => $sumselNews->load('author:id,name,username'),
            'moreArticles' => $moreArticles,
            'moreAuthors' => $moreAuthors,
        ]);
    }
}
