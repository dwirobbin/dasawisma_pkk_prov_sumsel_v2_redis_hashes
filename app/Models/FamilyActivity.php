<?php

namespace App\Models;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyActivity extends Model
{
    use HasFactory;

    protected $table = 'family_activities';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'family_head_id',
        'up2k_activity',
        'env_health_activity',
    ];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class, 'family_head_id', 'id');
    }
}
