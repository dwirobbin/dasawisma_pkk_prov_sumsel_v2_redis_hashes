<?php

namespace App\Http\Controllers\Backend\DataInput;

use App\Http\Controllers\Controller;
use App\Models\FamilyHead;
use Illuminate\Http\Request;

class FamilyHeadController extends Controller
{
    public function __invoke(FamilyHead $familyHead)
    {
        return view('pages.backend.data-input.members.family-heads.edit', compact('familyHead'));
    }
}
