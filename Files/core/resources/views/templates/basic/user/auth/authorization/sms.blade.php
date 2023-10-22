@extends($activeTemplate .'layouts.frontend')
@section('content')

    <main class="main">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections mb-5">
            @include($activeTemplate.'partials.breadcrumb')
            <div class="contact-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="contact-area">
                                <div class="contact-form-area code-verify-area p-0">
                                    <h3 class="title">@lang('Please Verify Your Mobile to Get Accesss')</h3>
                                    <form class="contact-form" action="{{route('user.verify.sms')}}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center mb-10-none">
                                            <div class="col-lg-12 form-group">
                                                <label for="">@lang('Your Mobile Number'):  <strong>{{auth()->user()->mobile}}</strong></label>
                                                <input type="text" name="sms_verified_code" id="code" maxlength="7" class="form-control" placeholder="@lang('Enter verification code')">
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                                    <div class="checkbox-item">
                                                        <label for="c1">@lang('If you don\'t get any code ')<a href="{{route('user.send.verify.code')}}?type=phone">@lang('Resend')</a></label>

                                                        @if ($errors->has('resend'))
                                                            <br/>
                                                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <button type="submit" class="submit-btn">@lang('Submit')</button>
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
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush
