<?php

namespace App\Http\Requests;

use App\Constants\CouponManagementConstant;
use Illuminate\Foundation\Http\FormRequest;

class CouponManagementRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channels_id' => [ 'required'],
            'partners_id' => [ 'required'],
            'coupon_masters_id' => ['required']
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
            CouponManagementConstant::INPUT_PARTNER_ID => __('title.coupon.coupon_management.partner_name'),
            CouponManagementConstant::INPUT_CHANNEL_ID => __('title.coupon.coupon_management.channel_name'),
            CouponManagementConstant::INPUT_COUPON_MASTER_ID => __('title.coupon.coupon_management.coupon_master_name'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            VALIDATION_REQUIRED_IF => __('validation.required')
        ];
    }
}
