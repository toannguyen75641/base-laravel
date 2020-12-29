<?php

namespace App\Http\Requests;

use App\Constants\BusinessUserConstant;
use Illuminate\Foundation\Http\FormRequest;

class BusinessUserRequest extends FormRequest
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
        $authorityOffice = BusinessUserConstant::AUTHORITY_OFFICE;
        $authorityRegion = BusinessUserConstant::AUTHORITY_REGION;
        $authorityDepartment = BusinessUserConstant::AUTHORITY_DEPARTMENT;
        $authoritySalesPerson = BusinessUserConstant::AUTHORITY_SALES_PERSON;

        $rules = [
            BusinessUserConstant::INPUT_AUTHORITY => 'required',
            BusinessUserConstant::INPUT_OFFICES_ID => [
                VALIDATION_REQUIRED_IF . ':' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityOffice},{$authorityRegion},{$authorityDepartment},{$authoritySalesPerson}"
            ],
            BusinessUserConstant::INPUT_REGIONS_ID => [
                VALIDATION_REQUIRED_IF . ':' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityRegion},{$authorityDepartment},{$authoritySalesPerson}"
            ],
            BusinessUserConstant::INPUT_DEPARTMENTS_ID => [
                VALIDATION_REQUIRED_IF . ':' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityDepartment},{$authoritySalesPerson}"
            ],
            BusinessUserConstant::INPUT_SALES_PERSONS_ID => [
                VALIDATION_REQUIRED_IF . ':' . BusinessUserConstant::INPUT_AUTHORITY . ",{$authoritySalesPerson}"
            ],
            BusinessUserConstant::INPUT_USER_ID => [
                'required',
                'min:3',
                'max:30',
                'alpha_num',
                'unique:' . BusinessUserConstant::TABLE_NAME . ',' . BusinessUserConstant::INPUT_USER_ID . ',' . $this->id
            ],
            BusinessUserConstant::INPUT_NAME => 'required|min:1|max:50',
        ];
        if (!isset($this->id)
                || (isset($this->id) && $this->password)) {
            $rules[BusinessUserConstant::INPUT_PASUWADO] = [
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
            BusinessUserConstant::INPUT_AUTHORITY => __('title.business.user.field.authority'),
            BusinessUserConstant::INPUT_OFFICES_ID => __('title.business.user.authority.1'),
            BusinessUserConstant::INPUT_REGIONS_ID => __('title.business.user.authority.2'),
            BusinessUserConstant::INPUT_DEPARTMENTS_ID => __('title.business.user.authority.3'),
            BusinessUserConstant::INPUT_SALES_PERSONS_ID => __('title.business.user.authority.4'),
            BusinessUserConstant::INPUT_USER_ID => __('title.business.user.field.user_id'),
            BusinessUserConstant::INPUT_NAME => __('title.business.user.field.name'),
            BusinessUserConstant::INPUT_PASUWADO => __('title.business.user.field.password')
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
            BusinessUserConstant::INPUT_USER_ID . '.alpha_num' => __('validation.custom.kddi.user.user_id.alpha_num'),
            BusinessUserConstant::INPUT_USER_ID . '.min' => __('validation.custom.kddi.user.user_id.min'),
            BusinessUserConstant::INPUT_USER_ID . '.max' => __('validation.custom.kddi.user.user_id.max'),
            BusinessUserConstant::INPUT_NAME . '.min' => __('validation.custom.kddi.user.name.min'),
            BusinessUserConstant::INPUT_NAME . '.max' => __('validation.custom.kddi.user.name.max'),
            BusinessUserConstant::INPUT_PASUWADO . '.min' => __('validation.custom.kddi.user.password.min'),
            BusinessUserConstant::INPUT_PASUWADO . '.regex' => __('validation.custom.kddi.user.password.regex'),
            BusinessUserConstant::INPUT_PASUWADO . '.confirmed' => __('validation.custom.kddi.user.password.confirmed'),
        ];
    }
}
