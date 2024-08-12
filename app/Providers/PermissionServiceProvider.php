<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function (User $user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Throwable $th) {
            Log::error('error: ' . $th->getMessage());
        }

        Blade::directive('role', function ($role) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$role})) { ?>";
        });
        Blade::directive('endrole', fn ($role) => "<?php } ?>");

        // check permission
        Blade::directive('permission', function ($permission) {
            return "<?php if (auth()->check() && auth()->user()->can({$permission})) { ?>";
        });
        Blade::directive('endpermission', fn ($permission) => "<?php } ?>");
    }
}
