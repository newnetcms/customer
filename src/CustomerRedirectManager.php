<?php

namespace Newnet\Customer;

class CustomerRedirectManager
{
    public function afterLogin()
    {
        return route('customer.web.customer.profile');
    }

    public function afterRegister()
    {
        return route('customer.web.customer.profile');
    }

    public function afterLogout()
    {
        return route('customer.web.customer.login');
    }

    public function ifAuthenticated()
    {
        return route('customer.web.customer.profile');
    }

    public function ifUnauthenticated()
    {
        return route('customer.web.customer.login');
    }
}
