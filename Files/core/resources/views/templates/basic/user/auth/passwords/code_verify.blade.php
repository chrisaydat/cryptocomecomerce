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
                                    <h3 class="title">@lang('Verification Code')</h3>
                                    <form class="contact-form" action="{{ route('user.password.verify.code') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="row justify-content-center mb-10-none">
                                            <div class="col-lg-12 form-group">
                                                <input type="text" name="code" id="code" maxlength="7" class="form-control" placeholder="@lang('Enter verification code')">
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                                    <div class="checkbox-item">
                                                        <label for="c1">@lang('Please check including your Junk/Spam Folder.')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <button type="submit" class="submit-btn">@lang('Verify Code')</button>
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
