<?php

namespace App\Http\Controllers\Backend\DataInput;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('pages.backend.data-input.members.index');
    }

    public function create()
    {
        return view('pages.backend.data-input.members.create');
    }
}
