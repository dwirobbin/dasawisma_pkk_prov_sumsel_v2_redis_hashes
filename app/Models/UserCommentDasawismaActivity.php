<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLikeCommentDasawismaActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCommentDasawismaActivity extends Model
{
    use HasFactory;

    protected $table = 'user_comments_dasawisma_activities';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'user_id',
        'dasawisma_activity_id',
        'body',
        'comment_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dasawismaActivity(): BelongsTo
    {
        return $this->belongsTo(DasawismaActivity::class, 'dasawisma_activity_id', 'id');
    }

    public function childrens()
    {
        return $this->hasMany(Self::class, 'comment_id', 'id');
    }

    public function likeCommentDasawismaActivities(): HasMany
    {
        return $this->hasMany(UserLikeCommentDasawismaActivity::class, 'comment_id', 'id');
    }

    public function totalLikedCommentByUsers(): int
    {
        return $this->likeCommentDasawismaActivities()->count();
    }
}
