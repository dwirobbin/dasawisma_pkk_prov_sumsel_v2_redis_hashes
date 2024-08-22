<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Dasawisma;
use App\Models\FamilyHead;
use App\Models\FamilyMember;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('pages.backend.home-index', [
            'title'     => 'Beranda',
        ]);
    }
}
