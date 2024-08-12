<?php

namespace App\Observers;

use App\Models\Dasawisma;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class DasawismaObserver implements ShouldHandleEventsAfterCommit
{
    private function clearRedis()
    {
        Redis::flushDB();
    }

    /**
     * Handle the Dasawisma "created" event.
     */
    public function created(Dasawisma $dasawisma): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the Dasawisma "updated" event.
     */
    public function updated(Dasawisma $dasawisma): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the Dasawisma "deleted" event.
     */
    public function deleted(Dasawisma $dasawisma): void
    {
        $this->clearRedis();
    }

    /**
     * Handle the Dasawisma "restored" event.
     */
    public function restored(Dasawisma $dasawisma): void
    {
        //
    }

    /**
     * Handle the Dasawisma "force deleted" event.
     */
    public function forceDeleted(Dasawisma $dasawisma): void
    {
        //
    }
}
