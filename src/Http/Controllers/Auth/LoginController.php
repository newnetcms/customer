<?php

namespace Newnet\Customer\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    public function username()
    {
        return config('cms.customer.login_username');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('customer::auth.login');
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if ($redirect = request('redirect')) {
            return $redirect;
        }

        $config = config('cms.customer.redirect_after_login', route('customer.web.customer.profile'));

        return is_callable($config) ? $config() : $config;
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        $config = config('cms.customer.redirect_after_logout', route('customer.web.customer.login'));
        $redirectAfterLogout = is_callable($config) ? $config() : $config;

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect($redirectAfterLogout);
    }

    protected function credentials(Request $request)
    {
        if ($this->username() == 'email_phone') {
            $value = $request->input($this->username());
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'phone';
            }

            return [
                $field => $value,
                'password' => $request->input('password'),
            ];
        } else {
            return $request->only($this->username(), 'password');
        }
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        $testLogin = $this->guard()->attempt($credentials, $request->boolean('remember', true));
        if (!$testLogin) {
            if (isset($credentials['phone']) && preg_match('/^\+84/', $credentials['phone'])) {
                $credentials['phone'] = preg_replace('/^\+84/', '0', $credentials['phone']);

                return $this->guard()->attempt($credentials, $request->boolean('remember', true));
            }
        }

        return $testLogin;
    }
}
