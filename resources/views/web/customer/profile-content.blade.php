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
                    <a href="#" class="item item__active">{{ setting_trans('account_information') }}</a>
                    <a href="{{ route('customer.web.your-cart') }}" class="item">{{ setting_trans('cart') }}</a>
                    <a href="{{ route('customer.web.program.payment-history') }}" class="item">{{ setting_trans('payment_history') }}</a>
                    <a href="{{ route('customer.web.customer.logout') }}" class="item">{{ setting_trans('logout') }}</a>
                </div>
            </div>
            <div class="profile__content">
                <form enctype="multipart/form-data" action="{{ route('customer.web.customer.profile') }}" method="POST" class="form">
                    @csrf
                    <input type="file" id="avt" name="avatar" onchange="sub()" accept="image/*"  style="display: none"/>
                    <div class="w_48">
                        <div class="input__wrap">
                            <label for="name" class="label">{{ setting_trans('name') }}</label>
                            <input
                                    autocomplete="off"
                                    id="name"
                                    name="name"
                                    class="input"
                                    type="text"
                                    placeholder="{{ setting_trans('name') }}"
                                    value="{{ auth()->user()->name }}"
                            />
                        </div>
                    </div>
                    <div class="w_48">
                        <div class="input__wrap">
                            <label for="phone" class="label">{{ setting_trans('phone') }}</label>
                            <input
                                    autocomplete="off"
                                    id="phone"
                                    name="phone"
                                    class="input"
                                    type="text"
                                    placeholder="{{ setting_trans('phone') }}"
                                    value="{{ auth()->user()->phone }}"
                            />
                        </div>
                    </div>
                    <div class="w_48">
                        <div class="input__wrap">
                            <label for="email" class="label">{{ setting_trans('email') }}</label>
                            <input
                                    autocomplete="off"
                                    id="email"
                                    name="email"
                                    class="input"
                                    type="text"
                                    placeholder="{{ setting_trans('email') }}"
                                    value="{{ auth()->user()->email }}"
                                    readonly
                            />
                        </div>
                    </div>

                    <div class="w_48">
                        <div class="input__wrap">
                            <label for="birthday" class="label">{{ setting_trans('birthday') }}</label>
                            <input style="color: #000"
                                   autocomplete="off"
                                   id="birthday"
                                   name="birthday"
                                   class="input"
                                   type="date"
                                   value="{{ auth()->user()->birthday }}"
                            />
                        </div>
                    </div>
                    <div class="w_48">
                        <div class="input__wrap">
                            <label for="country_code_residence" class="label">{{ setting_trans('country_of_residence') }}</label>
                            <select name="country_code_residence" id="country_code_residence" class="input__select">
                                @foreach(get_countries_options() as $option)
                                    <option value="{{ $option['value'] }}" @if($option['value'] == auth()->user()->country_code_residence) selected @endif >
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{--                        <div class="w_48">--}}
                    {{--                            <div class="input__wrap">--}}
                    {{--                                <label for="country_code" class="label">Country</label>--}}
                    {{--                                <select name="country_code" id="country_code" class="input__select">--}}
                    {{--                                    @foreach(get_countries_options() as $option)--}}
                    {{--                                        <option value="{{ $option['value'] }}" @if($option['value'] == auth()->user()->country_code) selected @endif>--}}
                    {{--                                            {{ $option['label'] }}--}}
                    {{--                                        </option>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    <div class="w_100">
                        <div class="input__wrap">
                            <label for="address" class="label">{{ setting_trans('address') }}</label>
                            <input
                                    autocomplete="off"
                                    id="address"
                                    name="address"
                                    class="input"
                                    type="text"
                                    placeholder="{{ setting_trans('address') }}"
                                    value="{{ auth()->user()->address }}"
                            />
                        </div>
                    </div>
                    <div class="list__btn">
                        <button id="updateProfile" type="submit" class="btn__save">{{ setting_trans('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function sub() {
            document.getElementById('updateProfile').click();
        }
    </script>
@endpush
