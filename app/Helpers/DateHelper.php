<?php

namespace App\Helpers;

use App\Models\Holiday;
use Carbon\Carbon;

class DateHelper
{
    public static function isWorkingDay(Carbon $date): bool
    {
        $isWeekend = $date->isWeekend();
        $isHoliday = Holiday::where('holiday_date', $date->format('Y-m-d'))->exists();
        return !$isWeekend && !$isHoliday;
    }

    public static function getNextWorkingDay(Carbon $date): Carbon
    {
        while (!self::isWorkingDay($date)) {
            $date->addDay();
        }
        return $date;
    }
}
