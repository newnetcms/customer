<?php

namespace Newnet\Customer\Http\Middleware;

use Closure
use Illuminate\Auth\AuthenticationException;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectToWithGuard($request, $guards)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $guards
     * @return string|null
     */
    protected function redirectToWithGuard($request, $guards)
    {
        if (!$request->expectsJson()) {
            if (in_array('customer', $guards)) {
                $config = config('cms.customer.redirect_if_unauthenticated', route('customer.web.customer.login'));

                return is_callable($config) ? $config() : $config;
            } elseif (\Route::has('customer.web.customer.login')) {
                return route('customer.web.customer.login');
            } else {
                return url('customer/login');
            }
        }
    }
}
