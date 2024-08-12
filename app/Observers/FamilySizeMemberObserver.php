<?php

namespace App\Observers;

use App\Models\FamilySizeMember;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Redis;

class FamilySizeMemberObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        $keys = Redis::keys("data-recap:*:fn:*");

        Redis::del($keys);
    }

    /**
     * Handle the FamilySizeMember "created" event.
     */
    public function created(FamilySizeMember $familySizeMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilySizeMember "updated" event.
     */
    public function updated(FamilySizeMember $familySizeMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilySizeMember "deleted" event.
     */
    public function deleted(FamilySizeMember $familySizeMember): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilySizeMember "restored" event.
     */
    public function restored(FamilySizeMember $familySizeMember): void
    {
        //
    }

    /**
     * Handle the FamilySizeMember "force deleted" event.
     */
    public function forceDeleted(FamilySizeMember $familySizeMember): void
    {
        //
    }
}
