<?php

namespace App\Http\Controllers\Backend\DataRecap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function index(Request $request)
    {
        $param = match (true) {
            str_contains(url()->current(), '/index') => null,
            str_contains(url()->current(), '/area-code') => $request->code,
            default => $request->slug,
        };

        return view('pages.backend.data-recap.family-member-index', [
            'title' => 'Rekap Data Anggota Keluarga',
            'param' => $param
        ]);
    }
}
