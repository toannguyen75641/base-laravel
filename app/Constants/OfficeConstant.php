<?php

namespace App\Constants;

/**
 * Class OfficeConstant
 *
 * @package App\Constants
 *
 * @uses constant for column and value of model office
 */
class OfficeConstant
{
    const INPUT_ID = 'id';
    const INPUT_NAME = 'name';
    const INPUT_PARTNER = 'partner';
    const INPUT_CODE = 'code';
    const INPUT_LOGO = 'logo';
    const INPUT_DELETE_AT = 'deleted_at';

    const COLUMNS_SELECT = [
        OfficeConstant::INPUT_ID,
        OfficeConstant::INPUT_NAME
    ];
}
