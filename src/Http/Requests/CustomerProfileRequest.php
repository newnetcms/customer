<?php

namespace Newnet\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerProfileRequest extends FormRequest
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
        $customerId = get_current_customer_id();

        $rules = [
            'name' => 'required',
            'password' => 'nullable|min:6|required_with:password_confirmation|string|confirmed',
            'avatar' => 'nullable|image|max:2048',
        ];

        if ($this->input('email')) {
            $rules['email'] = 'required|unique:customer__customers,email,'.$customerId;
        }

        if ($this->input('phone')) {
            $rules['phone'] = 'required|unique:customer__customers,phone,'.$customerId;
        }

        return $rules;
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
