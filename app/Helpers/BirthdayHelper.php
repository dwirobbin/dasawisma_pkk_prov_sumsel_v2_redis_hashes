<?php

namespace App\Helpers;

use Carbon\Carbon;

class BirthdayHelper
{
    public static function defaultUserImage(): string
    {
        return asset('src/img/auth/profile_default.png');
    }

    public static function isBirthdayInXDays(Carbon $startDate, Carbon $birthdate, int $numberOfDays): bool
    {
        $future = $startDate->copy()->addDays($numberOfDays);
        $birthdate->year = $startDate->year;

        if ($birthdate->isPast()) {
            return false;
        }

        return $birthdate->lessThanOrEqualTo($future) && $future->greaterThanOrEqualTo($startDate);
    }
}
