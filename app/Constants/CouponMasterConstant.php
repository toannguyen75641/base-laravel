<?php

namespace App\Constants;

/**
 * Class CouponMasterConstant
 *
 * @package App\Constants
 *
 * @uses constant for column and value of model coupon master
 */
class CouponMasterConstant
{
    const INPUT_MEASURE_CODE = 'measure_code';
    const INPUT_SYS_PERIOD_FROM = 'sys_period_from';
    const INPUT_SYS_PERIOD_TO = 'sys_period_to';
    const INPUT_MEASURE_NAME = 'measure_name';
    const INPUT_OPEN_DATE = 'open_date';
    const INPUT_FLG = 'flg';
    const INPUT_PERIOD_FROM = 'period_from';
    const INPUT_PERIOD_TO = 'period_to';
    const INPUT_BENEFIT_AMOUNT = 'benefit_amount';
    const INPUT_COUPON_IMG = 'coupon_img';
    const INPUT_EXPLAIN = 'explain';
    const INPUT_LINK_TEXT_1 = 'link_text_1';
    const INPUT_LINK_URL_1 = 'link_url_1';
    const INPUT_LINK_TEXT_2 = 'link_text_2';
    const INPUT_LINK_URL_2 = 'link_url_2';
    const INPUT_LINK_TEXT_3 = 'link_text_3';
    const INPUT_LINK_URL_3 = 'link_url_3';
    const INPUT_COUPON_NAME = 'coupon_name';
    const INPUT_BENEFIT_EXPLAIN = 'benefit_explain';
    const INPUT_TARGET = 'target';
    const INPUT_CONDITION = 'condition';
    const INPUT_CAUTION = 'caution';
    const INPUT_HEADING_1 = 'heading_1';
    const INPUT_HEADING_2 = 'heading_2';
    const INPUT_NOTE = 'note';
    const INPUT_MESSAGE = 'message';
    const INPUT_SMS_MESSAGE = 'sms_message';
    const INPUT_FORCED_FLG = 'forced_flg';
    const INPUT_FORCED_OFFICES_FLG = 'forced_offices_flg';
    const INPUT_FORCED_SALES_PERSONS_FLG = 'forced_sales_persons_flg';

    const HEADER_MEASURE_CODE = '施策コード';
    const HEADER_SYS_PERIOD_FROM = '利用期間From';
    const HEADER_SYS_PERIOD_TO = '利用期間To';

    const HEADER_CSV = [
        CouponConstant::INPUT_CODE => CouponConstant::HEADER_CODE,
        CouponMasterConstant::INPUT_MEASURE_CODE => CouponMasterConstant::HEADER_MEASURE_CODE,
        CouponMasterConstant::INPUT_SYS_PERIOD_FROM => CouponMasterConstant::HEADER_SYS_PERIOD_FROM,
        CouponMasterConstant::INPUT_SYS_PERIOD_TO => CouponMasterConstant::HEADER_SYS_PERIOD_TO,
    ];
    const SELECT_COLUMN = [
        FIELD_ID,
        CouponMasterConstant::INPUT_MEASURE_NAME,
        CouponMasterConstant::INPUT_OPEN_DATE,
        CouponMasterConstant::INPUT_FLG,
        CouponMasterConstant::INPUT_PERIOD_FROM,
        CouponMasterConstant::INPUT_PERIOD_TO,
        CouponMasterConstant::INPUT_BENEFIT_AMOUNT,
        CouponMasterConstant::INPUT_EXPLAIN,
        CouponMasterConstant::INPUT_LINK_TEXT_1,
        CouponMasterConstant::INPUT_LINK_URL_1,
        CouponMasterConstant::INPUT_LINK_TEXT_2,
        CouponMasterConstant::INPUT_LINK_URL_2,
        CouponMasterConstant::INPUT_LINK_TEXT_3,
        CouponMasterConstant::INPUT_LINK_URL_3,
        CouponMasterConstant::INPUT_COUPON_NAME,
        CouponMasterConstant::INPUT_BENEFIT_EXPLAIN,
        CouponMasterConstant::INPUT_TARGET,
        CouponMasterConstant::INPUT_CONDITION,
        CouponMasterConstant::INPUT_CAUTION,
        CouponMasterConstant::INPUT_HEADING_1,
        CouponMasterConstant::INPUT_HEADING_2,
        CouponMasterConstant::INPUT_NOTE,
        CouponMasterConstant::INPUT_MESSAGE,
        CouponMasterConstant::INPUT_SMS_MESSAGE,
        CouponMasterConstant::INPUT_FORCED_FLG
    ];

    const FLG_PUBLIC = 0;
    const FLG_PRIVATE = 1;
    const FLG_DRAFT = 2;
    const FLG = [
        CouponMasterConstant::FLG_PUBLIC => '公開',
        CouponMasterConstant::FLG_PRIVATE => '非公開',
        CouponMasterConstant::FLG_DRAFT => '下書き'
    ];

    const UNSELECTED = 0;
    const FORCED_OFFICES_FLG = 1;
    const FORCES_SALES_PERSONS_FLG = 2;
    const SELECT_BOTH = 3;

    const CHECK_BOX_COLUMN = [
        CouponMasterConstant::INPUT_FORCED_OFFICES_FLG,
        CouponMasterConstant::INPUT_FORCED_SALES_PERSONS_FLG
    ];
}
