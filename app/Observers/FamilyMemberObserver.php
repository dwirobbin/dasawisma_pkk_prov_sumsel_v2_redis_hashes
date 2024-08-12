<?php

namespace App\Observers;

use App\Models\FamilyMember;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class FamilyMemberObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        $keys = Redis::keys("data-recap:*:fm:*");

        Redis::del($keys);
    }

    /**
     * Handle the FamilyMember "created" event.
     */
    public function created(FamilyMember $familyMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyMember "updated" event.
     */
    public function updated(FamilyMember $familyMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyMember "deleted" event.
     */
    public function deleted(FamilyMember $familyMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyMember "restored" event.
     */
    public function restored(FamilyMember $familyMember): void
    {
        //
    }

    /**
     * Handle the FamilyMember "force deleted" event.
     */
    public function forceDeleted(FamilyMember $familyMember): void
    {
        //
    }
}
