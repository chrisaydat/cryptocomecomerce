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
                        <div class="ticket-area mt-30">
                            <div class="row justify-content-center mt-4">
                                <div class="col-md-12">
                                    <div class="dashboard-area">
                                        <div class="panel-card-header d-flex flex-wrap align-items-center justify-content-between"><div class="panel-card-title text-white">{{ __($pageTitle) }}</div>
                                            <a href="{{route('ticket') }}" class="btn--base border--rounded">
                                                @lang('My Support Ticket')
                                            </a>
                                        </div>

                                        <div class="panel-card-body">
                                            <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="name">@lang('Name')</label>
                                                        <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form--control" placeholder="@lang('Enter your name')" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="email">@lang('Email address')</label>
                                                        <input type="email"  name="email" value="{{@$user->email}}" class="form--control" placeholder="@lang('Enter your email')" readonly>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="website">@lang('Subject')</label>
                                                        <input type="text" name="subject" value="{{old('subject')}}" class="form--control" placeholder="@lang('Subject')" >
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="priority">@lang('Priority')</label>
                                                        <select name="priority" class="form--control">
                                                            <option value="3">@lang('High')</option>
                                                            <option value="2">@lang('Medium')</option>
                                                            <option value="1">@lang('Low')</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inputMessage">@lang('Message')</label>
                                                        <textarea name="message" id="inputMessage" rows="6" class="form--control">{{old('message')}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="row form-group align-items-center">
                                                    <div class="col-sm-9 file-upload">
                                                        <label for="inputAttachments">@lang('Attachments')</label>

                                                        <input type="file" name="attachments[]" id="inputAttachments" class="form--control mb-2" />

                                                        <div id="fileUploadsContainer"></div>
                                                        <p class="ticket-attachments-message text-white">
                                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                        </p>
                                                    </div>

                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn--success text-white border--rounded btn-sm addFile">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="row form-group justify-content-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn--success text-white border--rounded" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                                    </div>
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
        </div>
    </section>
</main>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group">
                        <input type="file" name="attachments[]" class="form--control my-3" required />
                        <div class="input-group-append support-input-group">
                            <span class="input-group-text btn btn--danger text-white border--rounded support-btn remove-btn">x</span>
                        </div>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
