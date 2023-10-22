<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- popup css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <!-- x-zoom css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/xzoom.css')}}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <!-- custom css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <!-- site color -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php?color1='.$general->base_color)}}">

    @stack('style-lib')

    @stack('style')
</head>
<body>
    @php
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobile_code = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
    @endphp


    <div class="preloader">
        <div class="surface">
            <div class="coin"><i class="fab fa-bitcoin"></i></div>
            <div class="shadow"></div>
        </div>
    </div>

    <a href="#" class="scrollToTop"><i class="las la-angle-double-up"></i></a>


    @include($activeTemplate.'partials.header')
    @yield('content')
    @include($activeTemplate.'partials.footer')



    <div class="account-section">
        <div class="section-bg-image"></div>
        <div class="account-area change-form">
            <div class="account-close"></div>
            <div class="account-tab">
                <ul class="nav nav-tabs mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="register-tab" data-toggle="tab"
                            href="#register" role="tab" aria-controls="register"
                            aria-selected="true">@lang('Register')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login"
                            role="tab" aria-controls="login" aria-selected="false">@lang('Login')</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form class="account-form" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>@lang('First Name')*</label>
                                    <input type="text" class="form-control form--control" name="firstname" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Last Name')*</label>
                                    <input type="text" class="form-control form--control" name="lastname" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Country')*</label>
                                    <select name="country" id="country" class="form-control form--control">
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Mobile')*</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text mobile-code">

                                            </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                        </div>
                                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" placeholder="@lang('Your Phone Number')">
                                    </div>
                                    <small class="text-danger mobileExist"></small>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Email')*</label>
                                    <input id="email" type="email" name="email" class="form-control form--control checkUser" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Username')*</label>
                                    <input type="text" id="username" name="username" class="form-control form--control checkUser" required>
                                    <small class="text-danger usernameExist"></small>
                                </div>
                                <div class="col-lg-6 form-group hover-input-popup">
                                    <label>@lang('Password')*</label>
                                    <input id="password" type="password" class="form-control form--control" name="password" required>

                                    @if($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Confirm Password')*</label>
                                    <input id="password-confirm" type="password" class="form-control  form--control" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                @include($activeTemplate.'partials.custom_captcha')

                                @if($general->agree)

                                    <div class="col-lg-12 form-group">
                                        <div class="form-group custom-check-group">
                                            <input type="checkbox" id="level-1" name="agree" required>
                                            <label for="level-1"> @lang('I have read and agree with the')

                                            @foreach ($policyElements as $item)
                                                <a href="{{route('policy',[$item->id, slug($item->data_values->heading)])}}" class="text--base">{{__(@$item->data_values->heading)}} @if(!$loop->last),@endif </a>
                                            @endforeach
                                        </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="submit-btn">@lang('Register Now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <div class="login-form">
                            <form class="account-form" method="POST" action="{{ route('user.login')}}">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Username')*</label>
                                        <input type="text" class="form-control form--control" name="username" value="{{ old('username') }}" placeholder="@lang('Username or Email')" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Password')*</label>
                                        <input type="password" class="form-control form--control" name="password" placeholder="@lang('Enter password')" required>
                                    </div>

                                    @include($activeTemplate.'partials.custom_captcha')
                                    <div class="col-lg-12 form-group">
                                        <div class="form-group custom-check-group">
                                            <input type="checkbox" id="level-2" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="level-2">@lang('Remember Me')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                            <div class="checkbox-item">
                                                <label><a href="javascript:void(0)" class="forget-pass-btn">@lang('Forgot Password')?</a></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="submit-btn">@lang('Login Now')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="forget-pass-form d-none">
                            <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Select One')*</label>
                                        <select name="type" class="form-control form--control">
                                            <option value="email">@lang('E-Mail Address')</option>
                                            <option value="username">@lang('Username')</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="my_value"></label>
                                        <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                            <div class="checkbox-item">
                                                <label><a href="javascript:void(0)" class="forget-pass-btn login-back-btn">@lang('Back to Login')?</a></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="submit-btn">@lang('Send Password Code')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp


@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie-remove">
        <div class="cookie__wrapper">
            <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <p class="txt my-2">
                    @php echo @$cookie->data_values->description @endphp<br>
                <a href="{{ @$cookie->data_values->link }}" target="_blank" class="text--base mt-2">@lang('Read Policy')</a>
                </p>
                <button class="btn--base my-2 policy cookie">@lang('Accept')</button>
            </div>
            </div>
        </div>
    </div>
@endif


<div class="modal fade" id="existModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-white" id="existModalLongTitle">@lang('You are with us')</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h6 class="text-center text-white">@lang('You already have an account please Sign in ')</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn--base" data-dismiss="modal">@lang('Close')</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="quickView">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content py-4">
            <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="product-single-container">
                    <div class="row mb-30-none">
                        <div class="col-xl-5 col-md-6 mb-30">
                            <div class="product-container">
                                <img class="manage-preview" alt="@lang('image')">
                            </div>
                        </div>
                        <div class="col-xl-7 col-md-6 mb-30">
                            <div class="product-details-content">
                                <h2 class="product-title text-white product-name"></h2>
                                <div class="ratings-container d-flex flex-wrap align-items-center">
                                    <div class="product-ratings">
                                        <span class="ratings">
                                        </span>
                                    </div>
                                    <a href="javascript:void(0)" class="rating-link">(<span class="total-response"></span>)</a>
                                </div>
                                <hr class="short-divider">
                                <div class="price-box">
                                    <span class="product-price product-price"></span>
                                </div>
                                <div class="product-desc">
                                    <p class="product-description">
                                    </p>
                                </div>
                                <form>
                                    <input type="hidden" name="product_id" class="product-id">
                                    <div class="product-action d-flex flex-wrap align-items-center">
                                        <div class="product-quantity">
                                            <div class="product-plus-minus">
                                                <div class="dec qtybutton">-</div>
                                                <input class="product-plus-minus-box product-qty integer-validation" type="text" name="qty" value="1">
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn--base add-cart icon-shopping-cart addtocart" title="Add to Cart">@lang('Add to Cart')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.3.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.bundle.min.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!-- popup js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.js')}}"></script>
<!-- x-zoom js -->
<script src="{{asset($activeTemplateTrue.'js/xzoom.js')}}"></script>
<!-- setup js -->
<script src="{{asset($activeTemplateTrue.'js/setup.js')}}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
<!-- main -->
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
<!-- secure password js -->
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')

<script>
    "use strict";

    (function ($) {

        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        $('.cookie').on('click',function () {

            var url = "{{ route('cookie.accept') }}";

            $.get(url,function(response){

                if(response.success){
                   notify('success',response.success);
                   $('.cookie-remove').html('');
                }
            });

        });

        $('.forget-pass-btn').on('click',function () {
            $('.forget-pass-form').removeClass('d-none');
            $('.login-form').addClass('d-none');
        });

        $('.login-back-btn').on('click',function () {
            $('.forget-pass-form').addClass('d-none');
            $('.login-form').removeClass('d-none');
        });

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }


        @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
        @endif

        $('select[name=country]').change(function(){
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
        });
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif

        $('.checkUser').on('focusout',function(e){
            var url = '{{ route('user.checkUser') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            if ($(this).attr('name') == 'mobile') {
                var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                var data = {mobile:mobile,_token:token}
            }
            if ($(this).attr('name') == 'email') {
                var data = {email:value,_token:token}
            }
            if ($(this).attr('name') == 'username') {
                var data = {username:value,_token:token}
            }
            $.post(url,data,function(response) {
                if (response['data'] && response['type'] == 'email') {
                $('#existModalCenter').modal('show');
                }else if(response['data'] != null){
                $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                }else{
                $(`.${response['type']}Exist`).text('');
                }
            });
        });

        $(document).on('click', '.quick-view' ,function () {
            var modal = $('#quickView');
            var resource = $(this).data('resource');
            modal.find('.product-name').text(resource.name);
            modal.find('.product-price').text("{{$general->cur_sym}}" + resource.new_price);
            modal.find('.product-description').text(resource.short_description);
            modal.find('.manage-preview').attr("src",$(this).data('image'));
            modal.find('.product-id').val(resource.id);
            modal.find('.total-response').text(resource.total_response + " @lang('Reviews')");
            modal.find('.ratings').html('');

            for (let index = 0; index < resource.avg_rating; index++) {
                modal.find('.ratings').append(`<i class="las la-star"></i>`);
            }
            for (let index = 0; index < 5-resource.avg_rating; index++) {
                modal.find('.ratings').append(`<i class="lar la-star"></i>`);
            }

            modal.modal('show');
        });

        $(document).on('click','.remove-cart',function () {

            var id = $(this).data('id');
            var csrf = '{{csrf_token()}}'

            var url = "{{ route('remove.cart') }}";
            var data = {id:id, _token:csrf};

            var thisData = $(this);

            $.post(url, data,function(response){

                if(response){
                    $('.total-cart').text(response.cartCount);
                    $('.total-price').text("{{$general->cur_sym}}" +response.totalPrice);
                    thisData.closest('.remove-data').remove();

                    if (response.cartCount <= 0) {
                        location.reload(true);
                    }

                    if (response.shipable == 0) {
                        $('.shipable').html('');
                    }

                    notify('success','Product has been removed from cart successfully!');
                }else{
                    notify('error', response.error);
                }
            });

        });

        $(document).on("keypress", ".integer-validation", (function (e) {
            var t = e.charCode ? e.charCode : e.keyCode;
            if (t!=13 && 8 != t && (t < 2534 || t > 2543) && (t < 48 || t > 57)) return !1
        }))

        $('.addtocart').on('click',function () {
            var id = $('.product-id').val();
            var pQty = $('.product-qty').val();
            var csrf = '{{csrf_token()}}'

            $.ajax({
                type: "post",
                url: "{{ route('addtocart') }}",
                data:{product_id:id,qty:pQty, _token:csrf},
                dataType: "json",


                success: function (response) {
                    if(response.success){

                        notify('success', response.success);
                        $(document).find('.total-cart').text(response.cartCount);
                        $(document).find('.total-price').text(response.totalPrice);
                        $('.dropdown-cart-products').html('');
                        $('.dropdown-cart-products').html(response.html);

                        if (response.cartCount > 0) {

                            var checkoutHtml = `<div class="dropdown-cart-action">
                                                <a href="{{route('cart')}}" class="btn--base w-100">@lang('Go To Cart')</a>
                                            </div>`;
                            $('.checkout-btn').html(checkoutHtml);
                        }

                    }else{
                        notify('error', response.error);
                    }
                }
            });
        });
    })(jQuery);

</script>

</body>
</html>
