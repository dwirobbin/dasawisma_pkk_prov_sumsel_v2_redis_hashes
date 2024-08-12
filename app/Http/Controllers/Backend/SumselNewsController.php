<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SumselNews;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SumselNewsController extends Controller
{
    public function index(): View
    {
        return view('pages.backend.sumsel-news.index');
    }

    public function create(): View
    {
        return view('pages.backend.sumsel-news.create');
    }

    public function edit(SumselNews $sumselNews): View
    {
        return view('pages.backend.sumsel-news.edit', compact('sumselNews'));
    }
}
