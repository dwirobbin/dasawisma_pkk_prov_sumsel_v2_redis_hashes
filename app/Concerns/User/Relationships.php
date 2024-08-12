<?php

namespace App\Concerns\User;

use App\Models\User;
use App\Models\UserCommentSumselNews;
use App\Models\UserLikeCommentSumselNews;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Relationships
{
    public function comments(): HasMany
    {
        return $this->hasMany(UserCommentSumselNews::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(UserLikeCommentSumselNews::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
