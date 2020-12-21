<?php

namespace App\Helpers;

class ViewHelper
{
    /**
     * Check selected option.
     *
     * @param $condition
     * @param $value
     * @param $key
     *
     * @return string
     */
    public static function isSelected($condition, $value, $key = null)
    {
        $input = !is_null($key) && isset($condition[$key]) ? $condition[$key] : $condition;

        return isset($input) && $input == $value ? 'selected' : '';
    }
}
