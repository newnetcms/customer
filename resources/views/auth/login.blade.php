@extends('master')

@section('meta_title', __('customer::customer.login.meta_title'))

@section('body-class', 'login-layout')

@section('content')
    @includeFirst(['auth.login', 'customer::auth.login-content'])
@endsection
