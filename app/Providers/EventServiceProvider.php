<?php

namespace App\Providers;

use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Events\LoginViaToken;
// use Illuminate\Auth\Events\PasswordReset;
use App\Events\PasswordReset;
use App\Models\FamilyActivity;
use App\Models\FamilyBuilding;
use App\Models\FamilySizeMember;
use App\Observers\DasawismaObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\FamilyMemberObserver;
use App\Observers\FamilyActivityObserver;
use App\Observers\FamilyBuildingObserver;
use App\Observers\FamilySizeMemberObserver;
use App\Listeners\SendPasswordResetNotification;
use App\Listeners\SendLoginLinkViaTokenNotification;
use App\Models\FamilyHead;
use App\Observers\FamilyHeadObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordReset::class => [
            SendPasswordResetNotification::class,
        ],
        LoginViaToken::class => [
            SendLoginLinkViaTokenNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Dasawisma::class => [DasawismaObserver::class],
        FamilyHead::class => [FamilyHeadObserver::class],
        FamilyBuilding::class => [FamilyBuildingObserver::class],
        FamilySizeMember::class => [FamilySizeMemberObserver::class],
        FamilyMember::class => [FamilyMemberObserver::class],
        FamilyActivity::class => [FamilyActivityObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
