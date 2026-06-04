<?php

namespace App\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class RutoDate
{
    public static function now(): Carbon
    {
        return Carbon::now(config('app.timezone'));
    }

    public static function today(): Carbon
    {
        return Carbon::today(config('app.timezone'));
    }

    public static function formatDisplay(?CarbonInterface $date = null, string $format = 'l, d F Y'): string
    {
        $moment = $date
            ? Carbon::parse($date)->timezone(config('app.timezone'))
            : self::now();

        return $moment->locale(config('app.locale', 'id'))->translatedFormat($format);
    }
}
