<?php

namespace App\Models;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'family_head_id',
        'nik_number',
        'name',
        'slug',
        'birth_date',
        'status',
        'marital_status',
        'gender',
        'last_education',
        'profession',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class, 'family_head_id', 'id');
    }

    public function scopeSearch(Builder $query, string $searchTerm)
    {
        return $query
            ->where('dsw.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('p.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('r.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('v.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fh.kk_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.nik_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.birth_date', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.status', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.marital_status', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.gender', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.last_education', 'LIKE', "%{$searchTerm}%")
            ->orWhere('fm.profession', 'LIKE', "%{$searchTerm}%");
    }
}
