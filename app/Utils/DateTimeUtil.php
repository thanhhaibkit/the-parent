<?php

namespace App\Utils;

use App\Constants\TheParentConst;
use Carbon\Carbon;

class DateTimeUtil
{
    public static function getPastDaysToFetchData()
    {
        $pastDays = config(
            'theparent.past_days_to_fetch_data',
            TheParentConst::THE_PARENT_PAST_DAYS_TO_FETCH_DATA
        );

        $day = Carbon::now()->subDays($pastDays);

        return $day->format('Y-m-d') . 'T' . $day->format('H:i:s') . 'Z';
    }
}