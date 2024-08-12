<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Sluggable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsStringable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SumselNews extends Model
{
    use HasFactory;

    protected $table = 'sumsel_news';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'author_id',
        'is_published',
    ];

    protected $attributes = [
        'is_published' => false,
    ];

    protected $casts = [
        'body' => AsStringable::class,
        'is_published' => 'boolean',
        'created_at' => 'datetime',
    ];

    protected $sluggable = 'title';

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => !is_null($value)
                ? asset('storage/image/sumsel-news/' . $value)
                : asset('src/img/default-img.png')
        );
    }

    // protected function body(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Str::words(strip_tags($value), 10, '...')
    //     );
    // }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('sumsel_news.title', 'LIKE', "%$searchTerm%")
            ->orWhere('sumsel_news.body', 'LIKE', "%$searchTerm%")
            ->orWhere('users.name', 'LIKE', "%$searchTerm%");
    }

    public function getReadingTime()
    {
        $mins = round(str_word_count($this->body) / 250);
        $result = ($mins < 1) ? 1 : $mins;

        return $result . ' Menit';
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_likes_sumsel_news', 'sumsel_news_id', 'user_id')
            ->withPivot(['created_at', 'updated_at']);
    }

    public function totalLikedByUsers(): int
    {
        return $this->likedByUsers()->count();
    }

    public function commentedByUsers(): HasMany
    {
        return $this->hasMany(UserCommentSumselNews::class, 'sumsel_news_id', 'id');
    }

    public function totalCommentedByUsers(): int
    {
        return $this->commentedByUsers()->count();
    }
}
