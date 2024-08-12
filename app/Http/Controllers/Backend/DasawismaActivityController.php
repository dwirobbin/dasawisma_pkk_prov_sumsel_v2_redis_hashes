<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DasawismaActivity;
use Illuminate\Http\Request;

class DasawismaActivityController extends Controller
{
    public function index()
    {
        return view('pages.backend.dasawisma-activities.index');
    }

    public function create()
    {
        return view('pages.backend.dasawisma-activities.create');
    }

    public function edit(DasawismaActivity $dasawismaActivity)
    {
        return view('pages.backend.dasawisma-activities.edit', compact('dasawismaActivity'));
    }
}
