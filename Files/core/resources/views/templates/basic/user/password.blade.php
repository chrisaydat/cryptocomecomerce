@extends($activeTemplate.'layouts.frontend')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="card">

                    <div class="card-body">

                        <form action="" method="post" class="register">
                            @csrf
                            <div class="form-group">
                                <label for="password">@lang('Current Password')</label>
                                <input id="password" type="password" class="form-control" name="current_password" required autocomplete="current-password">
                            </div>
                            <div class="form-group hover-input-popup">
                                <label for="password">@lang('Password')</label>
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
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
                            <div class="form-group">
                                <label for="confirm_password">@lang('Confirm Password')</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="current-password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="mt-4 btn btn-success" value="@lang('Change Password')">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <main class="main-section">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections pb-60">

            @include($activeTemplate.'partials.breadcrumb')

            <div class="container">
                <div class="row mb-30-none">

                    @include($activeTemplate.'user.partials.sidenav')

                    <div class="col-xl-9 mb-30">
                        <div class="body-wrapper">

                            @include($activeTemplate.'user.partials.dashboard_header')

                            <div class="reset-area mt-30">
                                <div class="panel-card-header section--bg text-white">
                                    <div class="panel-card-title"><i class="las la-lock-open"></i> Reset Password</div>
                                </div>
                                <div class="panel-body section--bg border--base">
                                    <form class="panel-form" action="" method="post">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12 form-group">
                                                <label>@lang('Current Password')</label>
                                                <input type="password" class="form--control" name="current_password" required autocomplete="current-password">
                                            </div>
                                            <div class="col-lg-12 form-group hover-input-popup">
                                                <label>@lang('Password')</label>
                                                <input type="password" name="password" class="form--control">

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
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form--control" required>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <button type="submit" class="submit-btn">@lang('Submit Now')</button>
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

