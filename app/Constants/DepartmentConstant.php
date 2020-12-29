<?php

namespace App\Constants;

/**
 * Class DepartmentConstant
 *
 * @package App\Constants
 *
 * @uses constant for column and value of model department
 */
class DepartmentConstant
{
    const INPUT_ID = 'id';
    const INPUT_NAME = 'name';
    const INPUT_REGIONS_ID = 'regions_id';
    const INPUT_DELETED_AT = 'deleted_at';

    const COLUMNS_SELECT = [
        DepartmentConstant::INPUT_ID,
        DepartmentConstant::INPUT_NAME,
        DepartmentConstant::INPUT_REGIONS_ID,
        FIELD_UPDATED_AT
    ];
}
