<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::query()
            ->with('role:id,name')
            ->select(['id', 'name', 'username', 'email', 'photo', 'role_id'])
            ->when(
                auth()->user()->hasRole(['super-admin', 'admin']),
                fn (Builder $query) => $query->with(['admin:id,user_id,phone_number'])
            )
            ->where('id', '=', auth()->id())
            ->first();

        return view('pages.auth.profile-index', compact('user'));
    }
}
