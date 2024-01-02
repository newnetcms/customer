<?php

namespace Newnet\Customer\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Newnet\Customer\Models\Customer;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest:customer']);
    }

    public function showRegistrationForm()
    {
        return view('customer::auth.register');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => [
                config('cms.customer.validator.name') ? 'required' : null,
                'string',
                'max:255'
            ],
            'phone' => [
                config('cms.customer.validator.phone') ? 'required' : null,
                'numeric',
                'unique:customer__customers,phone'
            ],
            'email' => [
                config('cms.customer.validator.email') ? 'required' : null,
                'email',
                'unique:customer__customers'
            ],
            'password' => [
                config('cms.customer.validator.password') ? 'required' : null,
                config('cms.customer.validator.password_confirmed') ? 'confirmed' : null,
                'min:6'
            ],
        ], [], [
            'name' => __('customer::customer.name'),
            'phone' => __('customer::customer.phone'),
            'email' => __('customer::customer.email'),
            'password' => __('customer::customer.password'),
            'password_confirmation' => __('customer::customer.password_confirmation'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model|Customer
     */
    protected function create(array $data)
    {
        return Customer::create(array_filter([
            'email' => $data['email'] ?? null,
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
        ]));
    }

    /**
     * Get the post register redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $config = config('cms.customer.redirect_after_register', route('customer.web.customer.profile'));

        return is_callable($config) ? $config() : $config;
    }
}
