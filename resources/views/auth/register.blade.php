@extends('master')

@section('meta_title', __('Register'))

@section('content')
    @includeFirst(['auth.register', 'customer::auth.register-content'])
@endsection
