<?php

namespace App\Http\Controllers\Backend\DataInput;

use App\Http\Controllers\Controller;
use App\Models\FamilyBuilding;
use Illuminate\Http\Request;

class FamilyBuildingController extends Controller
{
    public function __invoke(string $kk_number)
    {
        $familyBuilding = FamilyBuilding::from('family_buildings AS fb')
            ->select([
                'fb.id', 'fb.family_head_id', 'fb.staple_food', 'fb.have_toilet', 'fb.water_src',
                'fb.have_landfill', 'fb.have_sewerage', 'fb.pasting_p4k_sticker', 'fb.house_criteria',
                'fh.dasawisma_id', 'fh.kk_number', 'fh.family_head', 'fh.created_by'
            ])
            ->join('family_heads AS fh', 'fb.family_head_id', '=', 'fh.id')
            ->where('fh.kk_number', '=', $kk_number)
            ->first();

        return view('pages.backend.data-input.members.family-buildings.edit', compact('familyBuilding'));
    }
}
