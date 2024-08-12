<?php

namespace App\Models;

use App\Traits\Sluggable;
use App\Traits\GenerateUniqueName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dasawisma extends Model
{
    use HasFactory, GenerateUniqueName, Sluggable;

    protected $table = 'dasawismas';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'slug',
        'rt',
        'rw',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $sluggable = 'name';

    /**
     * Get the province that owns the Dasawisma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    /**
     * Get the regency that owns the Dasawisma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    /**
     * Get the district that owns the Dasawisma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Get the village that owns the Dasawisma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    public function scopeSearch(Builder $query, string $searchTerm)
    {
        return $query
            ->where('dsw.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('dsw.rt', 'LIKE', "%{$searchTerm}%")
            ->orWhere('dsw.rw', 'LIKE', "%{$searchTerm}%")
            ->orWhere('p.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('r.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('v.name', 'LIKE', "%{$searchTerm}%");
    }
}
