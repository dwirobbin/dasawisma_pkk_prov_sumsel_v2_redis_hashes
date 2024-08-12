<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dasawisma;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyHead extends Model
{
    use HasFactory;

    protected $table = 'family_heads';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'dasawisma_id',
        'kk_number',
        'family_head',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function dasawisma(): BelongsTo
    {
        return $this->belongsTo(Dasawisma::class, 'dasawisma_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function scopeSearch(Builder $query, string $searchTerm)
    {
        return $query
            ->where('fh.kk_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fh.family_head', 'LIKE', "%{$searchTerm}%")
            ->orWhere('dsw.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('p.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('r.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('v.name', 'LIKE', "%{$searchTerm}%");
    }
}
