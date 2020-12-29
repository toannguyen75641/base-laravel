<?php

namespace App\Constants;

/**
 * Class RegionConstant
 *
 * @package App\Constants
 *
 * @uses constant for column and value of model region
 */
class RegionConstant
{
    const INPUT_ID = 'id';
    const INPUT_NAME = 'name';
    const INPUT_OFFICES_ID = 'offices_id';

    const COLUMNS_SELECT = [
        RegionConstant::INPUT_ID,
        RegionConstant::INPUT_NAME,
        RegionConstant::INPUT_OFFICES_ID
    ];
}
