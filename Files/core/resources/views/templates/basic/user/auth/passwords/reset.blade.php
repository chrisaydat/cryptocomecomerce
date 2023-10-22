@extends($activeTemplate.'layouts.frontend')

@section('content')

    <main class="main">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections mb-5">
            @include($activeTemplate.'partials.breadcrumb')
            <div class="contact-section">
                <div class="container">
                    <div class="contact-area">
                        <div class="row justify-content-center mb-30-none">
                            <div class="col-lg-12 mb-30">
                                <div class="contact-form-area code-verify-area p-0">
                                    <h3 class="title">@lang('Reset Password')</h3>
                                    <form class="contact-form" method="POST" action="{{ route('user.password.update') }}">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="row justify-content-center mb-10-none">
                                            <div class="col-lg-12 form-group hover-input-popup">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="@lang('Password')" required>
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
                                            <div class="col-lg-12 form-group">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('Password Confirmation')" required>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <button type="submit" class="submit-btn">@lang('Reset Password')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>

@endsection


@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush
