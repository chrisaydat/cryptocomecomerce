@extends($activeTemplate.'layouts.frontend')
@section('content')
<main class="main-section">
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start All-sections
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="all-sections pb-60">

        @include($activeTemplate.'partials.breadcrumb')
        <div class="container pb-60">
            <div class="row mb-30-none">
                <div class="col-xl-12 mb-30">
                    <div class="cart-area">
                        <div class="panel-table">
                            <div class="panel-card-body section--bg table-responsive">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th class="text-left">@lang('Product Name')</th>
                                            <th>@lang('Quantity')</th>
                                            <th>@lang('Unit Price')</th>
                                            <th>@lang('Total Price')</th>
                                            <th>@lang('Remove')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $item)

                                            <tr class="remove-data">
                                                <td data-label="@lang('Product Name')" class="text-left">
                                                    <div class="p-item d-flex flex-wrap align-items-center">
                                                        <div class="p-thumb">
                                                            <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->product->image[0],imagePath()['p_image']['size']) }}" alt="product">
                                                        </div>
                                                        <div class="p-content">
                                                            <h5 class="title text-white">{{__($item->product->name)}}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="@lang('Quantity')"> {{$item->qty}} </td>
                                                <td data-label="@lang('Unit Price')">{{$general->cur_sym}}{{$item->product->new_price}}</td>
                                                <td data-label="@lang('Total Price')">{{$general->cur_sym}}{{$item->total_price}}</td>
                                                <td data-label="@lang('Remove')">
                                                    <a href="javascript:void(0)" class="remove-product remove-cart" data-id="{{Crypt::encrypt($item->id)}}"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="shipping-details-area mt-60">
                        @auth
                            <form class="shipping-form" action="{{route('user.deposit.insert')}}" method="POST">
                                @csrf
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-8 col-lg-8 mb-30">
                                        <div class="shipping-wrapper shipable">
                                            @if ($shipable == 1)
                                                <h4 class="title text-white mb-20">@lang('Shipping Details')</h4>
                                                <div class="section--bg p-4 panel-card-body">
                                                    <div class="row justify-content-center">
                                                        <div class="col-xl-12 col-lg-12 form-group">
                                                            <label>@lang('Name') <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form--control" value="{{ auth()->user()->fullname }}" placeholder="@lang('First Name')" required>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 form-group">
                                                            <label>@lang('Contact No') <span class="text-danger">*</span></label>
                                                            <input type="text" name="mobile" class="form--control" value="{{ auth()->user()->mobile }}" placeholder="@lang('Enter contact no')" required>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 form-group">
                                                            <label>@lang('Email') <span class="text-danger">*</span></label>
                                                            <input type="email" name="email" class="form--control" value="{{ auth()->user()->email }}" placeholder="@lang('Enter valid email')" required>
                                                        </div>
                                                        <div class="col-xl-12 form-group">
                                                            <label>@lang('Full Address') <span class="text-danger">*</span></label>
                                                            <textarea class="form--control" name="address" placeholder="@lang('Enter full address')" required>{{auth()->user()->address->address}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 mb-30">
                                        <div class="cart-total-area">
                                            <h4 class="title text-white mb-20">@lang('Total')</h4>
                                            <div class="panel-table">
                                                <div class="panel-card-body section--bg table-responsive">
                                                    <table class="custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('Grand total')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td data-label="@lang('Grand total')" class="total-price">{{$general->cur_sym}}{{$totalPrice}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="payment-dropdown-area mt-30">
                                                <h4 class="title text-white mb-20">@lang('Make Payment')</h4>

                                                <input type="hidden" name="currency">
                                                <input type="hidden" name="method_code">
                                                <input type="hidden" name="amount"  value="{{$totalPrice}}">

                                                <select class="form--control" id="payment-methods">
                                                    @foreach($gatewayCurrency as $data)
                                                        <option value="1" data-methodcode="{{ $data->method_code }}" data-currency="{{ $data->currency }}">{{__($data->name)}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="checkout-btn d-flex justify-content-end form-group mt-30">
                                                <button type="submit" class="submit-btn w-100">@lang('Proceed To Checkout')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="row justify-content-between mb-30-none">
                                <div class="col-xl-4 col-lg-4 mb-30">
                                    <div class="cart-total-area">
                                        <div class="checkout-btn d-flex justify-content-end form-group">
                                            <a href="javascript:void(0)" class="btn--base w-100 account-open-btn">@lang('Login To Checkout')</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 mb-30">
                                    <div class="cart-total-area">
                                        <div class="panel-table">
                                            <div class="panel-card-body section--bg table-responsive">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('Grand total')</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td data-label="@lang('Grand total')" class="total-price">{{$general->cur_sym}}{{$totalPrice}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
    <script>
        "use strict";

        (function ($) {
            $('#payment-methods').on('change',function(){
                var methodCode = $(this).find('option:selected').data('methodcode');
                var currency = $(this).find('option:selected').data('currency');

                $( "input[name=currency]").val(currency);
                $( "input[name=method_code]").val(methodCode);

            }).change();
        })(jQuery);
    </script>
@endpush
