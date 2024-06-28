<?php

namespace App\Services;

use App\Helpers\DateHelper;
use Carbon\Carbon;

class DateService
{
    public function adjustToWorkingDay(string $date): string
    {
        $date = Carbon::parse($date);
        return DateHelper::getNextWorkingDay($date)->format('Y-m-d');
    }
}
