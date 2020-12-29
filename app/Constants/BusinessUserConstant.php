<?php

namespace App\Constants;

/**
 * Class BusinessUserConstant
 *
 * @package App\Constants
 *
 * @uses constant for column and value of model business user
 */
class BusinessUserConstant
{
    const TABLE_NAME = 'business_users';

    const INPUT_USER_ID = 'user_id';
    const INPUT_AUTHORITY = 'authority';
    const INPUT_NAME = 'name';
    const INPUT_PASUWADO = 'password';
    const INPUT_LOCKED = 'locked';
    const INPUT_LOCK_DATE = 'lock_date';
    const INPUT_FAILED_COUNT = 'failed_count';
    const INPUT_LAST_LOGIN_DATE = 'last_login_date';
    const INPUT_OFFICES_ID = 'offices_id';
    const INPUT_REGIONS_ID = 'regions_id';
    const INPUT_DEPARTMENTS_ID = 'departments_id';
    const INPUT_SALES_PERSONS_ID = 'sales_persons_id';
    const INPUT_STATUS = 'status';
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

    const AUTHORITY_OFFICE = 1;
    const AUTHORITY_REGION = 2;
    const AUTHORITY_DEPARTMENT = 3;
    const AUTHORITY_SALES_PERSON = 4;
    const AUTHORITY = [
        BusinessUserConstant::AUTHORITY_OFFICE => '権限１',
        BusinessUserConstant::AUTHORITY_REGION => '権限２',
        BusinessUserConstant::AUTHORITY_DEPARTMENT => '権限３',
        BusinessUserConstant::AUTHORITY_SALES_PERSON => '権限４'
    ];

    const ID_HEADER = '権限１ユーザーマスタID';
    const AUTHORITY_HEADER = 'ユーザー権限';
    const OFFICES_HEADER = '権限１';
    const REGIONS_HEADER = '権限２';
    const DEPARTMENTS_HEADER = '権限３';
    const SALES_PERSONS_HEADER = '権限４';
    const NAME_HEADER = 'ユーザー名';
    const USER_ID_HEADER = 'ユーザーID';
    const PASUWADO_HEADER = 'パスワード';
    const STATUS_HEADER = 'ステータス';
    const DELETED_AT_HEADER = '削除フラグ';


    const CSV_HEADER = [
        FIELD_ID => BusinessUserConstant::ID_HEADER,
        BusinessUserConstant::INPUT_AUTHORITY => BusinessUserConstant::AUTHORITY_HEADER,
        BusinessUserConstant::INPUT_OFFICES_ID => BusinessUserConstant::OFFICES_HEADER,
        BusinessUserConstant::INPUT_REGIONS_ID => BusinessUserConstant::REGIONS_HEADER,
        BusinessUserConstant::INPUT_DEPARTMENTS_ID => BusinessUserConstant::DEPARTMENTS_HEADER,
        BusinessUserConstant::INPUT_SALES_PERSONS_ID => BusinessUserConstant::SALES_PERSONS_HEADER,
        BusinessUserConstant::INPUT_NAME => BusinessUserConstant::NAME_HEADER,
        BusinessUserConstant::INPUT_USER_ID => BusinessUserConstant::USER_ID_HEADER,
        BusinessUserConstant::INPUT_PASUWADO => BusinessUserConstant::PASUWADO_HEADER,
        BusinessUserConstant::INPUT_STATUS => BusinessUserConstant::STATUS_HEADER,
        BusinessUserConstant::INPUT_DELETE_AT => BusinessUserConstant::DELETED_AT_HEADER
    ];
}
