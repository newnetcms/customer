@extends('master')

@section('meta_title', __('Register'))

@section('body-class', 'register-layout')

@section('content')
    @includeFirst(['auth.register', 'customer::auth.register-content'])
@endsection
