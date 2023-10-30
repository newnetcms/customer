@extends('master')

@section('meta_title', __('customer::customer.profile.meta_title'))

@section('content')
    @includeFirst(['customer.profile', 'customer::web.customer.profile-content'])
@endsection
