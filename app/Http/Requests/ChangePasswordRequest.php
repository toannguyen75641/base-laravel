<?php

namespace App\Http\Requests;

use App\Rules\PasswordHashRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => [ 'required','min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]*$/', new PasswordHashRule()],
            'new_password' => [ 'required','min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]*$/'],
            'new_password_confirm' => ['required', 'same:new_password']
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
            'old_password.required' => __('message.error.required.admin_password_old'),
            'old_password.min' => __('message.error.min_max.admin_password'),
            'old_password.regex' => __('message.error.regex.admin_password'),
            'new_password.required' => __('message.error.required.admin_password_new'),
            'new_password.min' => __('message.error.min_max.admin_password'),
            'new_password.regex' => __('message.error.regex.admin_password'),
            'new_password_confirm.same' => __('message.error.confirm.admin_password_new'),
            'new_password_confirm.required' => __('message.error.required.admin_password_confirm'),
        ];
    }
}
