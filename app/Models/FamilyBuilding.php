<?php

namespace App\Models;

use App\Models\FamilyHead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyBuilding extends Model
{
    use HasFactory;

    protected $table = 'family_buildings';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'family_head_id',
        'staple_food',
        'have_toilet',
        'water_src',
        'have_landfill',
        'have_sewerage',
        'pasting_p4k_sticker',
        'house_criteria',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class, 'family_head_id', 'id');
    }
}
