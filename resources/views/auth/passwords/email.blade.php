@extends('master')

@section('meta_title', __('Reset Password'))

@section('body-class', 'forgot-password-layout')

@section('content')
    @includeFirst(['auth.forgot-password', 'customer::auth.passwords.email-content'])
@stop
