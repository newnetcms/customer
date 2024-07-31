<?php

namespace Newnet\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannedRequest extends FormRequest
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
            'customer_id' => 'required',
            'expired_at' => 'required_if:is_forever,0',
        ];
    }

    public function attributes()
    {
        return [
            'customer_id' => __('customer::banned.customer_id'),
            'expired_at' => __('customer::banned.expired_at'),
            'is_forever' => __('customer::banned.is_forever'),
        ];
    }
}
