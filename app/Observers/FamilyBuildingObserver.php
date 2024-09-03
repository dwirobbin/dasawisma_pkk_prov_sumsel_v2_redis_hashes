<?php

namespace App\Observers;

use App\Models\FamilyBuilding;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class FamilyBuildingObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        $keys = Redis::keys("data-recap:*:fb:*");

        Redis::del($keys);
    }

    /**
     * Handle the FamilyBuilding "created" event.
     */
    public function created(FamilyBuilding $familyBuilding): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyBuilding "updated" event.
     */
    public function updated(FamilyBuilding $familyBuilding): void
    {
        // $this->clearRedis();
    }

    /**
     * Handle the FamilyBuilding "deleted" event.
     */
    public function deleted(FamilyBuilding $familyBuilding): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the FamilyBuilding "restored" event.
     */
    public function restored(FamilyBuilding $familyBuilding): void
    {
        //
    }

    /**
     * Handle the FamilyBuilding "force deleted" event.
     */
    public function forceDeleted(FamilyBuilding $familyBuilding): void
    {
        //
    }
}
