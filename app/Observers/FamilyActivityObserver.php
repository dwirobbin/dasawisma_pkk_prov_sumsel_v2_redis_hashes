<?php

namespace App\Observers;

use App\Models\FamilyActivity;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Redis;

class FamilyActivityObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        $keys = Redis::keys("data-recap:*:fa:*");

        Redis::del($keys);
    }

    /**
     * Handle the FamilyActivity "created" event.
     */
    public function created(FamilyActivity $familyActivity): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyActivity "updated" event.
     */
    public function updated(FamilyActivity $familyActivity): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyActivity "deleted" event.
     */
    public function deleted(FamilyActivity $familyActivity): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyActivity "restored" event.
     */
    public function restored(FamilyActivity $familyActivity): void
    {
        //
    }

    /**
     * Handle the FamilyActivity "force deleted" event.
     */
    public function forceDeleted(FamilyActivity $familyActivity): void
    {
        //
    }
}
