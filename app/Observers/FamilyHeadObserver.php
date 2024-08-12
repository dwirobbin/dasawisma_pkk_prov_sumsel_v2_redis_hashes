<?php

namespace App\Observers;

use App\Models\FamilyHead;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class FamilyHeadObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        Redis::flushDB();
    }

    /**
     * Handle the FamilyHead "created" event.
     */
    public function created(FamilyHead $familyHead): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyHead "updated" event.
     */
    public function updated(FamilyHead $familyHead): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyHead "deleted" event.
     */
    public function deleted(FamilyHead $familyHead): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyHead "restored" event.
     */
    public function restored(FamilyHead $familyHead): void
    {
        //
    }

    /**
     * Handle the FamilyHead "force deleted" event.
     */
    public function forceDeleted(FamilyHead $familyHead): void
    {
        //
    }
}
