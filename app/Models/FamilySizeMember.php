<?php

namespace App\Models;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilySizeMember extends Model
{
    use HasFactory;

    protected $table = 'family_size_members';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'family_head_id',
        'toddlers_number',
        'pus_number',
        'wus_number',
        'blind_people_number',
        'pregnant_women_number',
        'breastfeeding_mother_number',
        'elderly_number',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class, 'family_head_id', 'id');
    }
}
