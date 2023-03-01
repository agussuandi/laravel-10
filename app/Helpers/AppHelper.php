<?php

namespace App\Helpers;

class AppHelper
{
    public static function DateFormat($date, $format, $empty = '-')
    {
        return ($date && $date !== null && trim($date) !== "") ? date($format, strtotime($date)) : $empty;
    }
}