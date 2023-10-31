@extends('master')

@section('meta_title', __('Reset Password'))

@section('content')
    @includeFirst(['auth.forgot-password', 'customer::auth.passwords.email-content'])
@stop
