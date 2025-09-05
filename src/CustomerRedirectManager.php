<?php

namespace Newnet\Customer;

class CustomerRedirectManager
{
    public static function afterLogin()
    {
        return route('customer.web.customer.profile');
    }

    public static function afterRegister()
    {
        return route('customer.web.customer.profile');
    }

    public static function afterLogout()
    {
        return route('customer.web.customer.login');
    }

    public static function ifAuthenticated()
    {
        return route('customer.web.customer.profile');
    }

    public static function ifUnauthenticated()
    {
        return route('customer.web.customer.login');
    }
}
