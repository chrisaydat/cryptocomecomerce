@extends($activeTemplate.'layouts.frontend')
@section('content')

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
                            <form class="panel-form" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="user-profile-area mt-30">
                                    <div class="row justify-content-center mb-30-none">
                                        <div class="col-xl-6 mb-30">
                                            <div class="panel panel-default">
                                                <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="panel-title"><i class="las la-user"></i> @lang('Two Factor Authenticator')</div>
                                                    <div class="panel-options">
                                                        <a href="javascript:void(0)" data-rel="collapse"><i class="las la-chevron-circle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="panel-body-inner">
                                                        <div class="profile-thumb-area text-center">
                                                            @if(auth()->user()->ts)
                                                                <a href="javascript:void(0)"  class="btn--base w-100 mt-20" data-toggle="modal" data-target="#disableModal">
                                                                    @lang('Disable Two Factor Authenticator')
                                                                </a>
                                                            @else
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="text" name="key" value="{{$secret}}" class="form-control form-control-lg" id="referralURL" readonly>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group mx-auto text-center">
                                                                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-content-area text-center mt-20">
                                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#enableModal" class="btn--base w-100 mt-20"
                                                                        data-clipboard-text="bbakaHwKsaMc">
                                                                        @lang('Enable Two Factor Authenticator')
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 mb-30">
                                            <div class="panel panel-default">
                                                <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="panel-title"><i class="las la-user"></i> @lang('Google Authenticator')</div>
                                                    <div class="panel-options-form">
                                                        <a href="javascript:void(0)" data-rel="collapse"><i class="las la-chevron-circle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-form-area">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12 form-group">
                                                            <p class="text-white">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                                        </div>

                                                        <div class="col-lg-12 form-group text-center">
                                                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank" class="btn--base w-100">@lang('Download App')</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>

    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title text-white">@lang('Verify Your Otp')</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger text-white" data-dismiss="modal">@lang('close')</button>
                        <button type="submit" class="btn btn--success text-white">@lang('verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger text-white" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success text-white">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


