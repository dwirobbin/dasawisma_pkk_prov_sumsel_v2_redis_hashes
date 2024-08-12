<?php

namespace App\Traits;

trait HasPermission
{
    public function hasPermission($permission)
    {
        return (bool) $this->role->permissions->where('slug', $permission->slug)->count();
    }

    public function hasRole(array $roles)
    {
        foreach ($roles as $role) {
            if ($this->role()->where('slug', $role)->exists()) {
                return true;
            }
        }

        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    private function hasPermissionThroughRole($permissions): bool
    {
        foreach ($permissions->roles as $role) {
            if ($this->role->where('slug', $role)->exists()) {
                return true;
            }
        }

        return false;
    }
}
