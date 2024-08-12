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
        $user = auth()->user();

        $dataCount['users'] = User::query()
            ->selectRaw("
                COUNT(users.id) AS users_count
            ")
            ->when($user->role_id == 3, function (Builder $query) {
                $query->where('role_id', '=', 3);
            })
            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                $query->where('role_id', '=', 2)
                    ->whereRelation('admin', 'village_id', '=', $user->admin->village_id);
            })
            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                $query->where('role_id', '=', 2)
                    ->whereRelation('admin', 'district_id', '=', $user->admin->district_id);
            })
            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                $query->where('role_id', '=', 2)
                    ->whereRelation('admin', 'regency_id', '=', $user->admin->regency_id);
            })
            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                $query->where('role_id', '=', 2)
                    ->whereRelation('admin', 'province_id', '=', $user->admin->province_id);
            })
            ->first();

        $dataCount['dasawismas'] = Dasawisma::query()
            ->selectRaw("
                COUNT(dasawismas.id) AS dasawismas_count
            ")
            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                $query->where('village_id', '=', $user->admin->village_id);
            })
            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                $query->where('district_id', '=', $user->admin->district_id);
            })
            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                $query->where('regency_id', '=', $user->admin->regency_id);
            })
            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                $query->where('province_id', '=', $user->admin->province_id);
            })
            ->first();

        $dataCount['families'] = FamilyHead::query()
            ->selectRaw("
                COUNT(family_heads.id) AS families_count
            ")
            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('dasawisma', 'village_id', '=', $user->admin->village_id);
            })
            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('dasawisma', 'district_id', '=', $user->admin->district_id);
            })
            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('dasawisma', 'regency_id', '=', $user->admin->regency_id);
            })
            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('dasawisma', 'province_id', '=', $user->admin->province_id);
            })
            ->first();

        $dataCount['family_members'] = FamilyMember::query()
            ->selectRaw("
                COUNT(family_members.id) AS family_members_count
            ")
            ->when($user->role_id == 2 && $user->admin->village_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('familyHead.dasawisma', 'village_id', '=', $user->admin->village_id);
            })
            ->when($user->role_id == 2 && $user->admin->district_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('familyHead.dasawisma', 'district_id', '=', $user->admin->district_id);
            })
            ->when($user->role_id == 2 && $user->admin->regency_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('familyHead.dasawisma', 'regency_id', '=', $user->admin->regency_id);
            })
            ->when($user->role_id == 2 && $user->admin->province_id != NULL, function (Builder $query) use ($user) {
                $query->whereRelation('familyHead.dasawisma', 'province_id', '=', $user->admin->province_id);
            })
            ->first();

        return view('pages.backend.home-index', [
            'title'     => 'Beranda',
            'dataCount' => $dataCount,
        ]);
    }
}
