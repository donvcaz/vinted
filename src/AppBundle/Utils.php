<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.24
 * Time: 09.00
 */

namespace AppBundle;


class Utils {

    public static function toFixed($float, $roundTo = 2)
    {
        return sprintf("%.{$roundTo}f",round((float)$float,$roundTo));
    }
} 