@extends('frontEnd.layout')

@section('content')

    <section id="inner-headline">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('Home') }}"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i>
                        </li>
                        <li class="active">{{ __('cruds.Society.Title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="content">
        <div class="container">
            <!-- بداية صفحة المجتمع -->
            <section class="content-row-no-bg" style="margin-top:2%; padding: 0 0 0 0">
                <div class="bg-page">
                    <!-- Cart Page Area Start -->
                    <section class="checkout-page">
                        <div class="container">
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong>{{ __('Error!') }}</strong> {{ $message }}
                                </div>
                            @endif

                            <form method="post" action="{{ route('pay') }}" data-cc-on-file="false"
                            {{-- <form method="post" action="{{ route('student.pay') }}" data-cc-on-file="false" --}}
                                data-stripe-publishable-key="1" id="payment-form"
                                class="require-validation" enctype="multipart/form-data">
                                @csrf
                                <div class="stripeToken"></div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="checkout-page-left-part">
                                            <div class="billing-address-box bg-white">

                                                <h6 class="font-16 font-medium color-heading mb-30">{{ __('Billing Address') }}
                                                </h6>

                                                <div class="row">
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="first_name" id="first_name" value="{{ $user->name }}"
                                                            required class="form-control" placeholder="{{ __('First Name') }}">
                                                        @if ($errors->has('first_name'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('first_name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="last_name" id="last_name" value="{{ $user->name }}"
                                                            required class="form-control" placeholder="{{ __('Last Name') }}">
                                                        @if ($errors->has('last_name'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('last_name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                                        <input type="email" name="email" value="{{ $user->email }}" id="email"
                                                            required class="form-control"
                                                            placeholder="{{ __('Email Address') }}">
                                                        @if ($errors->has('email'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- <div class="row">
                                                    <div class="col-md-12 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Address') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="address" id="address" value="{{ $student->address }}"
                                                            class="form-control" required placeholder="{{ __('Address') }}">
                                                        @if ($errors->has('street_address'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('street_address') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-30">
                                                        <label
                                                            class="font-medium font-15 color-heading">{{ __('Country') }}</label>

                                                        @if ($student->country_id && $student->country)
                                                            <input type="text" value="{{ $student->country->country_name }}"
                                                                class="form-control" readonly>
                                                            <input type="hidden" name="country_id"
                                                                value="{{ $student->country_id }}">
                                                        @else
                                                            <select name="country_id" id="country_id" class="form-select">
                                                                <option value="">{{ __('Select Country') }}</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        @if (old('country_id')) {{ old('country_id') == $country->id ? 'selected' : '' }} @else  {{ $student->country_id == $country->id ? 'selected' : '' }} @endif>
                                                                        {{ $country->country_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif

                                                        @if ($errors->has('country_id'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('country_id') }}</span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('State') }}</label>

                                                        @if ($student->state_id && $student->state)
                                                            <input type="text" value="{{ $student->state->name }}"
                                                                class="form-control" readonly>
                                                            <input type="hidden" name="state_id" value="{{ $student->state_id }}">
                                                        @else
                                                            <select name="state_id" id="state_id" class="form-select">
                                                                <option value="">{{ __('Select State') }}</option>
                                                                @if (old('country_id'))
                                                                    @foreach ($states as $state)
                                                                        <option value="{{ $state->id }}"
                                                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                                            {{ $state->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if ($student->country)
                                                                        @foreach ($student->country->states as $selected_state)
                                                                            <option value="{{ $selected_state->id }}"
                                                                                {{ $student->state_id == $selected_state->id ? 'selected' : '' }}>
                                                                                {{ $selected_state->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </select>
                                                        @endif
                                                        @if ($errors->has('state_id'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('state_id') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('City') }}</label>

                                                        @if ($student->city_id && $student->city)
                                                            <input type="text" value="{{ $student->city->name }}"
                                                                class="form-control" readonly>
                                                            <input type="hidden" name="city_id" value="{{ $student->city_id }}">
                                                        @else
                                                            <select name="city_id" id="city_id" class="form-select">
                                                                <option value="">{{ __('Select City') }}</option>
                                                                @if (old('state_id'))
                                                                    @foreach ($cities as $city)
                                                                        <option value="{{ $city->id }}"
                                                                            {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                                            {{ $city->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if ($student->state)
                                                                        @foreach ($student->state->cities as $selected_city)
                                                                            <option value="{{ $selected_city->id }}"
                                                                                {{ $student->city_id == $selected_city->id ? 'selected' : '' }}>
                                                                                {{ $selected_city->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </select>
                                                        @endif
                                                        @if ($errors->has('city_id'))
                                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                                {{ $errors->first('city_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Zip Code') }}</label>
                                                        <input type="text" name="postal_code" id="postal_code"
                                                            value="{{ $student->postal_code }}" class="form-control"
                                                            placeholder="{{ __('Zip code') }}">
                                                    </div>
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone_number" id="phone_number"
                                                            value="{{ $student->phone_number }}" required class="form-control"
                                                            placeholder="{{ __('Type your phone number') }}">
                                                    </div>
                                                </div> --}}

                                            </div>
                                            <div class="payment-method-box bg-white">
                                                <h6 class="font-16 font-medium color-heading mb-30">{{ __('Payment Method') }}
                                                </h6>
                                                {{-- @if (get_option('click_pay_status') == 1) --}}
                                                <div class="form-check payment-method-card-box other-payment-box pb-0 mb-15">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        value="clickpay"
                                                        {{ old('payment_method') == 'clickpay' ? 'checked' : '' }}
                                                        id="clickpayPayment">
                                                    <label class="form-check-label mb-0" for="clickpayPayment">
                                                        <span class="font-16 color-heading font-medium">Click Pay</span>
                                                    </label>
                                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                    <input type="hidden" name="package_price" value="{{ $package->price }}">
                                                </div>
                                                {{-- @endif --}}
                                                <div class="checkout-we-protect-content d-flex align-items-center mt-30">
                                                    <div class="flex-shrink-0">
                                                        <span class="iconify color-hover font-24"
                                                            data-icon="ant-design:lock-filled"></span>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 font-13">
                                                        {{ __('We protect your payment information using encryption to provide bank-level security') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="checkout-page-right-part sticky-top">
                                            <div class="checkout-right-side-box checkout-order-review-box">
                                                <div class="accordion" id="accordionExample1">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                                aria-controls="collapseOne">
                                                                {{ __('Order Review') }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
                                                            <div class="accordion-body">
                                                                <div class="checkout-items-count font-13 color-heading mb-2">
                                                                    {{ __('Items In Card') }}</div>
                                                                <div class="table-responsive mb-20">
                                                                    <table class="table bg-white checkout-table mb-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="checkout-course-item">
                                                                                    <div
                                                                                        class="card course-item wishlist-item border-0 d-flex align-items-center">

                                                                                        <div class="card-body flex-grow-1">
                                                                                            <h5 class="card-title course-title">
                                                                                                    <a href="{{ route('packages') }}" target="_blank">
                                                                                                        {{ $package->title_en }}</a>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                {{-- <td
                                                                                    class="wishlist-price font-13 color-heading text-end">
                                                                                    <div class="wishlist-remove font-13">
                                                                                        @if (get_currency_placement() == 'after')
                                                                                            {{ get_number_format(@$cart->price, 2) }}
                                                                                            {{ get_currency_symbol() }}
                                                                                        @else
                                                                                            {{ get_currency_symbol() }}
                                                                                            {{ get_number_format(@$cart->price, 2) }}
                                                                                        @endif
                                                                                    </div>
                                                                                    <div>

                                                                                    </div>
                                                                                </td> --}}
                                                                                <td
                                                                                    class="wishlist-price font-13 color-heading text-end">
                                                                                    <div class="wishlist-remove font-13">
                                                                                        {{ $package->price }} {{ __('cruds.Packages.currency') }}
                                                                                    </div>
                                                                                    <div>

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="checkout-right-side-box checkout-billing-summary-box">

                                                <div class="accordion" id="accordionExample3">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseThree" aria-expanded="true"
                                                                aria-controls="collapseThree">
                                                                {{ __('Billing Summary') }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                                                            <div class="accordion-body">
                                                                <table class="table billing-summary-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ __('Subtotal') }}</td>
                                                                            <td>
                                                                                {{-- @if (get_currency_placement() == 'after')
                                                                                    {{ get_number_format($carts->sum('price')) }}
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }}
                                                                                    {{ get_number_format($carts->sum('price')) }}
                                                                                @endif --}}
                                                                                    0 {{ __('cruds.Packages.currency') }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{ __('Discount') }}</td>
                                                                            <td>-

                                                                                {{-- @if (get_currency_placement() == 'after')
                                                                                    {{ get_number_format($carts->sum('discount')) }}
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }}
                                                                                    {{ get_number_format($carts->sum('discount')) }}
                                                                                @endif --}}
                                                                                0 {{ __('cruds.Packages.currency') }}

                                                                            </td>
                                                                        </tr>
                                                                        {{-- @if($carts->sum('shipping_charge') > 0) --}}
                                                                        <tr>
                                                                            <td>{{ __('Shipping Charge') }} </td>
                                                                            <td>
                                                                                {{-- @if (get_currency_placement() == 'after')
                                                                                    {{ get_number_format($carts->sum('shipping_charge')) }}
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }}
                                                                                    {{ get_number_format($carts->sum('shipping_charge')) }}
                                                                                @endif --}}
                                                                               0 {{ __('cruds.Packages.currency') }}

                                                                            </td>
                                                                        </tr>

                                                                        {{-- @endif --}}
                                                                        <tr>
                                                                            <td>{{ __('Platform Charge') }} </td>
                                                                            <td>
                                                                                {{-- @if (get_currency_placement() == 'after')
                                                                                    {{ get_platform_charge($carts->sum('price')+$carts->sum('shipping_charge')) }}
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }}
                                                                                    {{ get_platform_charge($carts->sum('price')+$carts->sum('shipping_charge')) }}
                                                                                @endif --}}
                                                                                0 {{ __('cruds.Packages.currency') }}

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="col">{{ __('Grand Total') }}</th>
                                                                            <th scope="col">
                                                                                {{-- @if (get_currency_placement() == 'after')
                                                                                    <span
                                                                                        class="grand_total">{{ get_number_format($carts->sum('price') + $carts->sum('shipping_charge') + get_platform_charge($carts->sum('shipping_charge')+$carts->sum('price'))) }}</span>
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }} <span
                                                                                        class="grand_total">{{ get_number_format($carts->sum('price') + $carts->sum('shipping_charge') + get_platform_charge($carts->sum('shipping_charge')+$carts->sum('price'))) }}</span>
                                                                                @endif --}}
                                                                                <span
                                                                                    class="grand_total">{{ $package->price }}</span>
                                                                                    {{ __('cruds.Packages.currency') }}

                                                                            </th>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                                <table class="table billing-summary-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ __('Conversion Rate') }} </td>
                                                                            <td>
                                                                                {{-- 1 {{ get_currency_symbol() }} = --}}
                                                                                <span class="selected_conversation_rate">?</span> <span
                                                                                    class="selected_currency"></span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="col">In<span
                                                                                    class="ms-1 gateway_calculated_rate_currency"></span>
                                                                            </th>
                                                                            <th scope="col" class="gateway_calculated_rate_price">
                                                                            </th>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <div class="row mb-30">
                                                                    <div class="col-md-12">
                                                                        <div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    value="" id="flexCheckChecked" checked>
                                                                                <label class="form-check-label mb-0"
                                                                                    for="flexCheckChecked">
                                                                                    Please check to acknowledge our <a
                                                                                        href=""
                                                                                        {{-- href="{{ route('privacy-policy') }}" --}}
                                                                                        class="color-hover text-decoration-underline">Privacy
                                                                                        & Terms Policy</a>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="row mb-30">
                                                                    @if (env('APP_DEMO') == 'active')
                                                                        <div class="col-md-12">
                                                                            <div class="">
                                                                                <button type="button"
                                                                                    class="theme-btn theme-button1 theme-button3 font-15 fw-bold w-100 appDemo">
                                                                                    {{ __('Pay') }}
                                                                                    <span
                                                                                        class="ms-1  gateway_calculated_rate_price"></span><span
                                                                                        class="ms-1 gateway_calculated_rate_currency"></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-12">
                                                                            {{-- <div class="sslcz-btn d-none">
                                                                                <input type="hidden" name="">
                                                                                <button
                                                                                    class="your-button-class theme-btn theme-button1 theme-button3 font-15 fw-bold w-100"
                                                                                    id="sslczPayBtn"
                                                                                    postdata="your javascript arrays or objects which requires in backend"
                                                                                >
                                                                                    {{ __('Pay') }}s
                                                                                    {{ @$sslcommerz_grand_total_with_conversion_rate }}
                                                                                </button>
                                                                            </div> --}}

                                                                            <div class="regular-btn">
                                                                                <button type="submit"
                                                                                    class="theme-btn theme-button1 theme-button3 font-15 fw-bold w-100 ">
                                                                                    {{ __('Pay') }}s
                                                                                    <span
                                                                                        class="ms-1  gateway_calculated_rate_price"></span><span
                                                                                        class="ms-1 gateway_calculated_rate_currency"></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- @php
                                $razorpay_pay_amount = $razorpay_grand_total_with_conversion_rate * 100;
                                $orderId = rand();
                            @endphp --}}


                            {{-- <div class="d-none">
                                <form action="{{ route('student.razorpay_payment') }}" method="POST" id="razorpay_payment">
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZORPAY_KEY') }}"
                                        data-amount="{{ $razorpay_pay_amount }}" data-buttontext="Pay" data-name="{{ get_option('app_name') }}"
                                        data-description="Buy Course" data-prefill.name="name" data-prefill.email="email" data-theme.color="#0000FF">
                                    </script>
                                </form>
                            </div> --}}

                            {{-- <div class="d-none">
                                <form action="{{ route('student.pay') }}" method="POST" id="paystack_payment">
                                    @csrf
                                    <input type="hidden" name="callback_url" value="{{ route('student.paystack_payment.callback') }}">
                                    <input type="hidden" name="orderID" value="{{ $orderId }}">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['orderID' => $orderId]) }}" >

                                    <input type="hidden" name="email" value="{{Auth::user()->email}}"> ="hidden" name="amount" value="{{$paystack_grand_total_with_conversion_rate * 100}}">
                                    <input type="hidden" name="currency" value="NGN">
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                    <input type="hidden" name="payment_method" value="paystack">
                                    {{ csrf_field() }}
                                </form>
                            </div> --}}

                        </div>
                    </section>
                    <!-- Cart Page Area End -->
                </div>
                {{-- <input type="hidden" class="clickpay_currency" value="{{ get_option('click_pay_currency') }}"> --}}
                {{-- <input type="hidden" class="clickpay_conversion_rate" value="{{ get_option('click_pay_conversion_rate') }}"> --}}
                {{-- <input type="hidden" class="fetchBankRoute" value="{{ route('student.fetchBank') }}"> --}}
            </section>
            <!-- نهاية صفحة المجتمع -->
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('input[type=radio][name=payment_method]').change(function () {
            var payment_method = $('input[name="payment_method"]:checked').val();
            var grand_total = parseFloat(($('.grand_total').html()));
            console.log(payment_method);
            if (payment_method === 'clickpay') {
                var rate = $('.clickpay_conversion_rate').val();
                var gateway_calculated_rate_price = (parseFloat(grand_total).toFixed(2));
                var currency = 'SAR';

                $('.selected_conversation_rate').html(rate)
                $('.selected_currency').html(currency)
                $('.gateway_calculated_rate_currency').html(currency)
                $('.gateway_calculated_rate_price').html(gateway_calculated_rate_price)
            }
        });
    </script>
@endsection
@push('script')
@endpush
