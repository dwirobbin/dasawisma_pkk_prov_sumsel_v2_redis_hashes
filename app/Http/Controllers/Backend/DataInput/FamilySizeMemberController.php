<?php

namespace App\Http\Controllers\Backend\DataInput;

use App\Http\Controllers\Controller;
use App\Models\FamilySizeMember;
use Illuminate\Http\Request;

class FamilySizeMemberController extends Controller
{
    public function __invoke(string $kk_number)
    {
        $familySizeMember = FamilySizeMember::from('family_size_members AS fsm')
            ->select([
                'fsm.id', 'fsm.family_head_id', 'fsm.toddlers_number', 'fsm.pus_number', 'fsm.wus_number', 'fsm.blind_people_number',
                'fsm.pregnant_women_number', 'fsm.breastfeeding_mother_number', 'fsm.elderly_number',
                'fh.dasawisma_id', 'fh.kk_number', 'fh.family_head', 'fh.created_by'
            ])
            ->join('family_heads AS fh', 'fsm.family_head_id', '=', 'fh.id')
            ->where('fh.kk_number', '=', $kk_number)
            ->first();

        return view('pages.backend.data-input.members.family-size-members.edit', compact('familySizeMember'));
    }
}
