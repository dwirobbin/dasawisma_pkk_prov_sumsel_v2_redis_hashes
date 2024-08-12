<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.backend.users.index');
    }

    public function create()
    {
        return view('pages.backend.users.create');
    }

    public function edit(User $user)
    {
        return view('pages.backend.users.edit', [
            'user' => $user->load('admin')
        ]);
    }
}
