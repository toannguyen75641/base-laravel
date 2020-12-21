<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

class StringHelper
{
    /**
     * Hash string.
     *
     * @param string $input
     *
     * @return string
     */
    public static function hash(string $input) : string
    {
        return Hash::make($input);
    }
}
