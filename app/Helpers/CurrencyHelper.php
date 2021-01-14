<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function beautyPrice($price)
    {
        if ($price >= 1000000000) {
            return round($price / 1000000000, 1) . ' tỉ';
        } elseif ($price > 0) {
            return round($price / 1000000, 0) . ' triệu';
        } else {
            return '0';
        }
    }
}