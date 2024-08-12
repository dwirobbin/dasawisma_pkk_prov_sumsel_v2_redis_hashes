<?php

namespace App\Http\Controllers\Backend\DataRecap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyBuildingController extends Controller
{
    public function index(Request $request)
    {
        $param = match (true) {
            str_contains(url()->current(), '/index') => null,
            str_contains(url()->current(), '/area-code') => $request->code,
            default => $request->slug,
        };

        return view('pages.backend.data-recap.family-building-index', [
            'title' => 'Rekap Data Info Bangunan',
            'param' => $param
        ]);
    }
}
