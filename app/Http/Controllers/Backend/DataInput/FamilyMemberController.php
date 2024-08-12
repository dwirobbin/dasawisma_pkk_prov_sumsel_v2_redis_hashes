<?php

namespace App\Http\Controllers\Backend\DataInput;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FamilyMember;

class FamilyMemberController extends Controller
{
    public function __invoke(string $kk_number)
    {
        $familyMembers = FamilyMember::from('family_members AS fm')
            ->select([
                'fm.id',
                'fm.family_head_id',
                'fm.name', 'fm.nik_number', 'fm.birth_date', 'fm.status',
                'fm.marital_status', 'fm.gender', 'fm.last_education', 'fm.profession',
                'fh.dasawisma_id', 'fh.kk_number', 'fh.family_head', 'fh.created_by'
            ])
            ->join('family_heads AS fh', 'fm.family_head_id', '=', 'fh.id')
            ->where('fh.kk_number', '=', $kk_number)
            ->get()
            ->toArray();

        return view('pages.backend.data-input.members.family-members.edit', compact('familyMembers'));
    }
}
