<?php

namespace Gameap\Helpers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

class DateHelper
{
    public static function convertToLocal(?Carbon $date): ?CarbonImmutable
    {
        if ($date === null) {
            return null;
        }

        $convertedDate = CarbonImmutable::createFromFormat(
            Carbon::DEFAULT_TO_STRING_FORMAT,
            $date->toDateTimeString(),
            'UTC'
        );
        return $convertedDate->setTimezone(config('timezone'));
    }

    public static function convertToUTC(?Carbon $date): ?CarbonImmutable
    {
        if ($date === null) {
            return null;
        }

        $convertedDate = CarbonImmutable::createFromFormat(
            Carbon::DEFAULT_TO_STRING_FORMAT,
            $date->toDateTimeString(),
            config('timezone')
        );
        return $convertedDate->setTimezone('UTC');
    }
}
