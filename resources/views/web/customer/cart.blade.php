@extends('master')

@section('meta_title', __('customer::customer.profile.meta_title'))

@section('content')
    <div class="page__profile">
        <div class="container-w">
            <div class="profile">
                <div class="profile__menu">
                    <div class="__info">
                        <div class="img">
                            <img src="{{ auth('customer')->user()->avatar  }}" alt="" />
                            <label for="avt">
                                <img src="{{ theme_url('images/i-avt.svg') }}" class="change__avt" alt="" />
                            </label>
                        </div>
                        <div class="name">{{ auth()->user()->name  }}</div>
                    </div>
                    <div class="list">
                        <a href="{{ route('customer.web.customer.profile') }}" class="item">{{ setting_trans('account_information') }}</a>
                        <a href="{{ route('customer.web.your-cart') }}" class="item item__active">{{ setting_trans('cart') }}</a>
                        <a href="{{ route('customer.web.program.payment-history') }}" class="item">{{ setting_trans('payment_history') }}</a>
                        <a href="{{ route('customer.web.customer.logout') }}" class="item">{{ setting_trans('logout') }}</a>
                    </div>
                </div>
                <div class="profile__content">
                    <form enctype="multipart/form-data" action="{{ route('customer.web.program.payment') }}" method="POST" class="form">
                        @csrf
                        <div class="w_100">
                            <div class="input__wrap">
                                <label for="payment_method" class="label">{{ setting_trans('payment_method') }}</label>
                                <select required name="payment_method" id="js-payment_method" class="input__select">
                                    <option value="">-- {{ setting_trans('payment_method') }} --</option>
                                    @foreach(list_payment_method() as $option)
                                        <option value="{{ $option['value'] }}" >
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w_100">
                            <div class="input__wrap">
                                <label for="school_id" class="label">{{ setting_trans('education_program') }}</label>
                                <select required name="school_id" id="js-school" class="input__select">
                                    <option value="">-- {{ setting_trans('education_program') }} --</option>
                                    @foreach(get_school_options() as $option)
                                        <option value="{{ $option['value'] }}" >
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w_100">
                            <div class="input__wrap">
                                <label for="js-program" class="label">{{ setting_trans('programs') }}</label>
                                <select required name="program_id" id="js-program" class="input__select">
                                    <option value="">-- {{ setting_trans('programs') }} --</option>

                                </select>
                            </div>
                        </div>
                        <div class="w_100">
                            <div class="input__wrap">
                                <label for="js-intake" class="label">{{ setting_trans('intake') }}</label>
                                <select required name="intake" id="js-intake" class="input__select">
                                    <option value="">-- {{ setting_trans('intake') }} --</option>

                                </select>
                            </div>
                        </div>
                        <div class="list__btn" style="display: none">
                            <div class="w_100" style="margin-bottom: 25px; text-align: left; margin-left: 5px">
                                <strong>{{ setting_trans('register_fee') }}: </strong> <span id="js-register-fee"></span>
                            </div>
                            <button id="updateProfile" type="submit" class="btn__save">{{ setting_trans('checkout') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var school_id = null
        var program_id = null
        $(document).ready(function (){
            $('#js-school').change(function (){
                school_id = $(this).val()
                $.ajax({
                    url: '{{ route('customer.web.ajax-program') }}',
                    type: 'GET',
                    data: {
                        school_id: $(this).val(),
                        token: '{{ csrf_token() }}'
                    },
                    success: function (res){
                        $("#js-program").html(res)
                    },
                    error: function (){

                    }
                })
            })
            $('#js-program').change(function (){
                program_id = $(this).val()
                $.ajax({
                    url: '{{ route('customer.web.ajax-intake') }}',
                    type: 'GET',
                    data: {
                        program_id: $(this).val(),
                        token: '{{ csrf_token() }}'
                    },
                    success: function (res){
                        $("#js-intake").html(res)

                    },
                    error: function (){

                    }
                })
            })
            $('#js-intake').change(function (){
                $.ajax({
                    url: '{{ route('customer.web.ajax-register-fee') }}',
                    type: 'GET',
                    data: {
                        school_id: school_id,
                        program_id: program_id,
                        token: '{{ csrf_token() }}'
                    },
                    success: function (res){
                        console.log(res.data.fee)
                        $("#js-register-fee").text(res.data.fee+' đ')
                        $('.list__btn').css('display', 'block')
                    },
                    error: function (){

                    }
                })
            })
        })
        function sub() {
            document.getElementById('updateProfile').click();
        }
    </script>
@endpush
