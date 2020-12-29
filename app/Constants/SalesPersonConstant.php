<?php

namespace App\Constants;

class SalesPersonConstant
{
    const INPUT_ID = 'id';
    const INPUT_NAME = 'name';
    const INPUT_DEPARTMENTS_ID = 'departments_id';
    const INPUT_STATUS = 'status';
    const INPUT_TYPE = 'type';
    const INPUT_CODE = 'code';
    const INPUT_OFFICES_ID = 'offices_id';
    const INPUT_TYPE_DETAIL = 'type_detail';
    const INPUT_DELETE_AT = 'deleted_at';

    const COLUMNS_SELECT = [
        SalesPersonConstant::INPUT_ID,
        SalesPersonConstant::INPUT_NAME,
        SalesPersonConstant::INPUT_OFFICES_ID,
        SalesPersonConstant::INPUT_DEPARTMENTS_ID
    ];
}
