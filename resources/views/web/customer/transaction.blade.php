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
                        <a href="{{ route('customer.web.your-cart') }}" class="item">{{ setting_trans('cart') }}</a>
                        <a href="{{ route('customer.web.program.payment-history') }}" class="item item__active">{{ setting_trans('payment_history') }}</a>
                        <a href="{{ route('customer.web.customer.logout') }}" class="item">{{ setting_trans('logout') }}</a>
                    </div>
                </div>
                <div class="profile__content">
                    <table class="table table-bordered" id="transaction">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ setting_trans('education_program') }}</th>
                                <th style="min-width: 100px">{{ setting_trans('amount') }}</th>
                                <th>{{ setting_trans('payment_method') }}</th>
                                <th>{{ setting_trans('status') }}</th>
                                <th>{{ setting_trans('payment_time') }}</th>
                                <th>{{ setting_trans('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions  as $transaction)
                            <tr>
                                <td>#{{ $transaction->order_id }}</td>
                                <td>
                                    {{ $transaction->school->name }}
                                    <br>
                                    <small>- {{ $transaction->program->name }}</small>
                                    <br>
                                    <small>- {{ find_intake($transaction->intake) }}</small>
                                </td>
                                <td>{{ number_format($transaction->amount, 0) }} đ</td>
                                <td>{{ $transaction->payment_method }}</td>
                                <td>
                                    @if($transaction->status == 'completed')
                                        <span class="span-success">{{ setting_trans('completed') }}</span>
                                    @elseif($transaction->status == 'failed')
                                        <span class="span-error">{{ setting_trans('failed') }}</span>
                                    @else
                                        <span class="span-pending">{{ setting_trans('pending') }}</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->payment_date }}</td>
                                <td>
                                    @if($transaction->status == 'pending')
                                        <a class="span-success" href="{{ route('customer.web.program.re-payment', $transaction->order_id) }}">
                                            {{ setting_trans('checkout') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
@push('styles')
    <style>
        .span-success{
            color: #fff;
            background: #078c12;
            padding: 3px 3px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
            min-width: 85px;
            text-align: center;
        }
        .span-pending{
            color: #333333;
            background: #dcad10;
            padding: 3px 3px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
            min-width: 85px;
            text-align: center;


        }
        .span-error{
            color: #fff;
            background: #a4012c;
            padding: 3px 3px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
            min-width: 85px;
            text-align: center;
        }
        #transaction {
            border-collapse: collapse;
            width: 100%;
        }

        #transaction td, #transaction th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #transaction tr:nth-child(even){background-color: #f2f2f2;}

        #transaction tr:hover {background-color: #ddd;}

        #transaction th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #13458b;
            color: white;
            font-size: 13px;
        }
        #transaction td {
            font-size: 13px;
        }
    </style>
@endpush
