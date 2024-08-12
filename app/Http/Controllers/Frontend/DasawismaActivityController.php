<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\DasawismaActivity;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DasawismaActivityController extends Controller
{
    public function index(): View
    {
        return view('pages.frontend.dasawisma-activities.index');
    }

    public function show(DasawismaActivity $dasawismaActivity): View
    {
        $moreArticles = DasawismaActivity::query()
            ->select(['title', 'slug', 'image', 'body', 'created_at'])
            ->where([
                ['id', '!=', $dasawismaActivity->id],
                ['is_published', '=', true],
            ])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $moreAuthors = User::query()
            ->select(['name', 'username'])
            ->withWhereHas('dasawismaActivities', fn (Builder $query) => $query
                ->where([
                    ['author_id', '!=', $dasawismaActivity->author_id],
                    ['is_published', '=', true],
                ]))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.frontend.dasawisma-activities.show', [
            'dasawismaActivity' => $dasawismaActivity->load('author:id,name,username'),
            'moreArticles' => $moreArticles,
            'moreAuthors' => $moreAuthors,
        ]);
    }
}
