<?php

namespace App\Http\Controllers\Backend;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        return view('pages.backend.permissions.index');
    }

    public function create()
    {
        return view('pages.backend.permissions.create');
    }

    public function edit(Permission $permission)
    {
        return view('pages.backend.permissions.edit', compact('permission'));
    }
}
