<?php

namespace App\Http\Requests;

use App\Constants\AdminUserConstant;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
        $rules = [
            AdminUserConstant::INPUT_USER_ID => [
                'required',
                'min:3',
                'max:30',
                'alpha_num',
                'unique:' . AdminUserConstant::TABLE_NAME . ',' . AdminUserConstant::INPUT_USER_ID . ',' . $this->id
            ],
            AdminUserConstant::INPUT_NAME => 'required|min:1|max:50',
        ];
        if (!isset($this->id)
                || (isset($this->id) && $this->password)) {
            $rules[AdminUserConstant::INPUT_PASUWADO] = [
                'required',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]*$/',
                'confirmed'
            ];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            AdminUserConstant::INPUT_USER_ID => __('title.kddi.user.field.user_id'),
            AdminUserConstant::INPUT_NAME => __('title.kddi.user.field.name'),
            AdminUserConstant::INPUT_PASUWADO => __('title.kddi.user.field.password')
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
            AdminUserConstant::INPUT_USER_ID . '.alpha_num' => __('validation.custom.kddi.user.user_id.alpha_num'),
            AdminUserConstant::INPUT_USER_ID . '.min' => __('validation.custom.kddi.user.user_id.min'),
            AdminUserConstant::INPUT_USER_ID . '.max' => __('validation.custom.kddi.user.user_id.max'),
            AdminUserConstant::INPUT_NAME . '.min' => __('validation.custom.kddi.user.name.min'),
            AdminUserConstant::INPUT_NAME . '.max' => __('validation.custom.kddi.user.name.max'),
            AdminUserConstant::INPUT_PASUWADO . '.min' => __('validation.custom.kddi.user.password.min'),
            AdminUserConstant::INPUT_PASUWADO . '.regex' => __('validation.custom.kddi.user.password.regex'),
            AdminUserConstant::INPUT_PASUWADO . '.confirmed' => __('validation.custom.kddi.user.password.confirmed'),
        ];
    }
}
