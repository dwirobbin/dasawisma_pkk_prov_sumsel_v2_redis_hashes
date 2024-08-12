<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.backend.roles.index');
    }

    public function create()
    {
        return view('pages.backend.roles.create');
    }

    public function edit(Role $role)
    {
        $permissionTitles = Permission::query()
            ->select('id', 'title', 'name', 'slug')
            ->get()
            ->groupBy('title')
            ->all();

        return view('pages.backend.roles.edit', [
            'role' => $role->load(['permissions:name,slug']),
            'permissionTitles' => $permissionTitles,
        ]);
    }
}
