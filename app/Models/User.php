<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use App\Traits\HasPermission;
use App\Models\DasawismaActivity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, HasPermission;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'photo',
        'role_id',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => !is_null($value)
                ? asset('storage/image/profiles/' . $value)
                : asset('src/img/auth/profile_default.png')
        );
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function dasawismaActivities(): HasMany
    {
        return $this->hasMany(DasawismaActivity::class, 'author_id', 'id');
    }

    public function sumselNews(): HasMany
    {
        return $this->hasMany(SumselNews::class, 'author_id', 'id');
    }

    public function likeDasawismaActivities(): BelongsToMany
    {
        return $this->belongsToMany(DasawismaActivity::class, 'users_likes_dasawisma_activities', 'user_id', 'dasawisma_activity_id')
            ->withPivot(['created_at', 'updated_at']);
    }

    public function likeSumselNews(): BelongsToMany
    {
        return $this->belongsToMany(SumselNews::class, 'users_likes_sumsel_news', 'user_id', 'sumsel_news_id')
            ->withPivot(['created_at', 'updated_at']);
    }

    public function hasLikedArticles(DasawismaActivity|SumselNews $model)
    {
        if ($model instanceof DasawismaActivity) {
            return $this->likeDasawismaActivities()->where('dasawisma_activity_id', $model->id)->exists();
        }

        if ($model instanceof SumselNews) {
            return $this->likeSumselNews()->where('sumsel_news_id', $model->id)->exists();
        }
    }

    public function commentDasawismaActivities(): HasMany
    {
        return $this->hasMany(UserCommentDasawismaActivity::class, 'user_id', 'id');
    }

    public function likeCommentDasawismaActivities(): HasMany
    {
        return $this->hasMany(UserLikeCommentDasawismaActivity::class, 'user_id', 'id');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('users.name', 'LIKE', "%$searchTerm%")
            ->orWhere('users.email', 'LIKE', "%$searchTerm%")
            ->orWhere(function (Builder $query) use ($searchTerm) {
                $query->withWhereHas('role', function (Builder $query) use ($searchTerm) {
                    $query->where('roles.name', 'LIKE', "%$searchTerm%");
                });
            });
    }

    public function scopeLastWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [carbon('1 week ago'), now()])->latest();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPassword($token));
    }
}
