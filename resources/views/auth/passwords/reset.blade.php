@extends('master')

@section('meta_title', __('Reset Password'))

@section('body-class', 'reset-password-layout')

@section('content')
    @includeFirst(['auth.reset-password', 'customer::auth.passwords.reset-content'])
@stop
