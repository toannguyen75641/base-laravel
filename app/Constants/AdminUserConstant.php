<?php

namespace App\Constants;

/**
 * Class AdminUserConstant
 *
 * @package App\Constants
 *
 * @uses define constant for column and value of model admin user
 */
class AdminUserConstant
{
    const TABLE_NAME = 'admin_users';

    const INPUT_USER_ID = 'user_id';
    const INPUT_NAME = 'name';
    const INPUT_PASUWADO = 'password';
    const INPUT_STATUS = 'status';
    const INPUT_LOCKED = 'locked';
    const INPUT_LOCK_DATE = 'lock_date';
    const INPUT_FAILED_COUNT = 'failed_count';
    const INPUT_LAST_LOGIN_DATE = 'last_login_date';
    const INPUT_DELETE_AT = 'deleted_at';

    const INPUT_PASUWADO_CONFIRMATION = 'password_confirmation';
    
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const STATUS = [
        BusinessUserConstant::STATUS_ACTIVE => '有効',
        BusinessUserConstant::STATUS_INACTIVE => '無効'
    ];

    const UNLOCK = 0;
    const LOCK = 1;

    const QUANTITY_OF_LOGIN_FAILED = 6;
    const DEFAULT_FAILED_COUNT = 0;
}
