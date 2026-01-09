<?php

namespace Newnet\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerChangePasswordRequest extends FormRequest
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
            'password' => 'min:6|string|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name'                  => __('customer::customer.name'),
            'phone'                 => __('customer::customer.phone'),
            'email'                 => __('customer::customer.email'),
            'password'              => __('customer::customer.password'),
            'password_confirmation' => __('customer::customer.password_confirmation'),
        ];
    }
}
