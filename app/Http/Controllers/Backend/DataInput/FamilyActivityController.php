<?php

namespace App\Http\Controllers\Backend\DataInput;

use App\Http\Controllers\Controller;
use App\Models\FamilyActivity;
use Illuminate\Http\Request;

class FamilyActivityController extends Controller
{
    public function __invoke(string $kk_number)
    {
        $familyActivity = FamilyActivity::from('family_activities AS fa')
            ->select([
                'fa.id', 'fa.family_head_id', 'fa.up2k_activity', 'fa.env_health_activity',
                'fh.dasawisma_id', 'fh.kk_number', 'fh.family_head', 'fh.created_by'
            ])
            ->join('family_heads AS fh', 'fa.family_head_id', '=', 'fh.id')
            ->where('fh.kk_number', '=', $kk_number)
            ->first();

        return view('pages.backend.data-input.members.family-activities.edit', compact('familyActivity'));
    }
}
