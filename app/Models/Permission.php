<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => str($value)->title(),
        );
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('name', 'LIKE', "%$searchTerm%");
    }

    public function isSuperAdmin(array $permTitles, Role $role): bool
    {
        if ($role->id !== auth()->user()->role_id) return false;

        $permsIDs1 = collect($permTitles['Role'])->map(fn ($perm) => $perm->id)->toArray();
        $permsIDs2 = collect($permTitles['Permission'])->map(fn ($perm) => $perm->id)->toArray();

        return $this->roles()->whereIn('permission_id', array_merge($permsIDs1, $permsIDs2))->exists();
    }
}
