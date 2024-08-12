<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanFilterByUser
{
    public function scopeByCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', auth()->id());
    }
}
