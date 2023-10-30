@extends('master')

@section('meta_title', __('customer::customer.login.meta_title'))

@section('content')
    @includeFirst(['customer.auth.login', 'customer::auth.login-content'])
@endsection
