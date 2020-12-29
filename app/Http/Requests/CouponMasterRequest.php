<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\CouponMasterConstant;

class CouponMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function rules()
    {
        return [
            CouponMasterConstant::INPUT_MEASURE_NAME => [
                'required',
                'min:2',
                'max:30',
                'alpha_num',
            ],
            CouponMasterConstant::INPUT_PERIOD_FROM => 'required',
            CouponMasterConstant::INPUT_PERIOD_TO => [
                'required',
                'after:' . CouponMasterConstant::INPUT_PERIOD_FROM
            ],
            CouponMasterConstant::INPUT_BENEFIT_AMOUNT => [
                'required',
                'numeric'
            ],
            CouponMasterConstant::INPUT_COUPON_IMG => [
                VALIDATION_REQUIRED_IF . ':' . HAS_FILE . ',0',
                'image',
                'mimes:jpeg,png,jpg',
                'max:3072'
            ],
            CouponMasterConstant::INPUT_EXPLAIN => 'required',
            CouponMasterConstant::INPUT_COUPON_NAME => 'required',
            CouponMasterConstant::INPUT_BENEFIT_EXPLAIN => 'required',
            CouponMasterConstant::INPUT_TARGET => 'required',
            CouponMasterConstant::INPUT_CONDITION => 'required',
            CouponMasterConstant::INPUT_CAUTION => 'required',
            CouponMasterConstant::INPUT_HEADING_1 => 'required',
            CouponMasterConstant::INPUT_HEADING_2 => 'required',
            CouponMasterConstant::INPUT_NOTE => 'required',
            CouponMasterConstant::INPUT_SMS_MESSAGE => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            CouponMasterConstant::INPUT_MEASURE_NAME => __('title.coupon.measure.field.measure_name'),
            CouponMasterConstant::INPUT_PERIOD_FROM => __('title.coupon.measure.field.period_time'),
            CouponMasterConstant::INPUT_PERIOD_TO => __('title.coupon.measure.field.period_time'),
            CouponMasterConstant::INPUT_BENEFIT_AMOUNT => __('title.coupon.measure.field.benefit_amount'),
            CouponMasterConstant::INPUT_COUPON_IMG => __('title.coupon.coupon_informartion.field.coupon_img'),
            CouponMasterConstant::INPUT_EXPLAIN =>  __('title.coupon.coupon_informartion.field.explain'),
            CouponMasterConstant::INPUT_COUPON_NAME => __('title.coupon.coupon_detail.field.coupon_name'),
            CouponMasterConstant::INPUT_BENEFIT_EXPLAIN => __('title.coupon.coupon_detail.field.benefit_explain'),
            CouponMasterConstant::INPUT_TARGET =>  __('title.coupon.coupon_detail.field.target'),
            CouponMasterConstant::INPUT_CONDITION =>  __('title.coupon.coupon_detail.field.condition'),
            CouponMasterConstant::INPUT_CAUTION =>  __('title.coupon.coupon_detail.field.caution'),
            CouponMasterConstant::INPUT_HEADING_1 =>  __('title.coupon.bar_code_display.field.heading'),
            CouponMasterConstant::INPUT_HEADING_2 =>  __('title.coupon.bar_code_display.field.heading'),
            CouponMasterConstant::INPUT_NOTE =>  __('title.coupon.bar_code_display.field.note'),
            CouponMasterConstant::INPUT_SMS_MESSAGE =>  __('title.coupon.sms_setting.field.sms_message'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            VALIDATION_REQUIRED_IF => __('validation.required'),
            CouponMasterConstant::INPUT_MEASURE_NAME . '.alpha_num' => __('validation.custom.coupon.coupon_master.measure_name.alpha_num'),
            CouponMasterConstant::INPUT_MEASURE_NAME . '.min' => __('validation.custom.coupon.coupon_master.measure_name.alpha_num'),
            CouponMasterConstant::INPUT_MEASURE_NAME . '.max' => __('validation.custom.coupon.coupon_master.measure_name.alpha_num'),
            CouponMasterConstant::INPUT_PERIOD_TO . '.after' => __('validation.custom.coupon.coupon_master.period_to.after'),
            CouponMasterConstant::INPUT_BENEFIT_AMOUNT . '.numeric' => __('validation.custom.coupon.coupon_master.benefit_amount.numeric'),
            CouponMasterConstant::INPUT_COUPON_IMG . '.image' => __('validation.custom.coupon.coupon_master.img.mimes'),
            CouponMasterConstant::INPUT_COUPON_IMG . '.mimes' => __('validation.custom.coupon.coupon_master.img.mimes'),
            CouponMasterConstant::INPUT_COUPON_IMG . '.max' => __('validation.custom.coupon.coupon_master.img.max'),
        ];
    }
}
