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
                    @auth
                        @include($activeTemplate.'user.partials.sidenav')


                    <div class="col-xl-9 mb-30">
                        <div class="body-wrapper">
                                @include($activeTemplate.'user.partials.dashboard_header')
                            @else
                            <div class="col-xl-12 mb-30">
                                <div class="body-wrapper">
                            @endauth
                            <div class="ticket-area mt-30">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="dashboard-area">
                                            <div class="panel-card-header section--bg text-white d-flex flex-wrap justify-content-between align-items-center">
                                                <h5 class="panel-card-title text-white mt-0 mb-0">
                                                    @if($my_ticket->status == 0)
                                                        <span class="badge badge--success py-2">@lang('Open')</span>
                                                    @elseif($my_ticket->status == 1)
                                                        <span class="badge badge--primary py-2">@lang('Answered')</span>
                                                    @elseif($my_ticket->status == 2)
                                                        <span class="badge badge--warning">@lang('Replied')</span>
                                                    @elseif($my_ticket->status == 3)
                                                        <span class="badge badge--dark">@lang('Closed')</span>
                                                    @endif
                                                    [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                                                </h5>
                                                <button class="btn btn--base close-button" type="button" title="@lang('Close Ticket')" data-toggle="modal" data-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                                                </button>
                                            </div>
                                            <div class="panel-card-body">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="dashboard-area">
                                                        <div class="panel-card-header bf" id="headingThree">
                                                            <h2 class="panel-card-title mb-0">
                                                                <a class="btn btn-link text-white collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                    <i class="fa fa-pencil-alt"></i> @lang('Reply')
                                                                </a>
                                                                <a class="btn btn-link text-white collapsed float-right accor" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                            <div class="panel-card-body">
                                                                @if($my_ticket->status != 4)
                                                                    <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="replayTicket" value="1">
                                                                        <div class="form-group">
                                                                            <textarea name="message" class="form--control" id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10"></textarea>
                                                                        </div>
                                                                        <div class="row justify-content-between align-items-start">
                                                                            <div class="col-md-9">
                                                                                <div class="row justify-content-between">
                                                                                    <div class="col-md-11">
                                                                                        <div class="form-group">
                                                                                            <label for="inputAttachments">@lang('Attachments')</label>
                                                                                            <input type="file" name="attachments[]" id="inputAttachments" class="form--control"/>
                                                                                            <div id="fileUploadsContainer"></div>
                                                                                            <p class="my-2 ticket-attachments-message text-white">
                                                                                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-1">
                                                                                        <div class="form-group">
                                                                                            <a href="javascript:void(0)" class="btn--base border--rounded px-1 py-0 addFile mt-40">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <button type="submit" class="btn btn--base text-white border--rounded mt-40">
                                                                                    <i class="fa fa-reply"></i> @lang('Reply')
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="dashboard-area mt-30">
                                                            <div class="panel-card-body">
                                                                @foreach($messages as $message)
                                                                    @if($message->admin_id == 0)
                                                                        <div class="row border border--base border-radius-3 my-3 py-3 mx-2">
                                                                            <div class="col-md-3 border-right text-right">
                                                                                <h5 class="my-3 text-white">{{ $message->ticket->name }}</h5>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <p class="text-white font-weight-bold my-3">
                                                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                                                <p class="text-white">{{$message->message}}</p>
                                                                                @if($message->attachments()->count() > 0)
                                                                                    <div class="mt-2">
                                                                                        @foreach($message->attachments as $k=> $image)
                                                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3 text-white"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="row border border--base border-radius-3 my-3 py-3 mx-2 section--bg">
                                                                            <div class="col-md-3 border-right text-right">
                                                                                <h5 class="my-3 text-white">{{ $message->admin->name }}</h5>
                                                                                <p class="lead text-white">@lang('Staff')</p>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <p class="text-white font-weight-bold my-3">
                                                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                                                <p class="text-white">{{$message->message}}</p>
                                                                                @if($message->attachments()->count() > 0)
                                                                                    <div class="mt-2">
                                                                                        @foreach($message->attachments as $k=> $image)
                                                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3 text-white"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title text-white"> @lang('Confirmation')!</h5>
                        <button type="button" class="close close-button text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong class="text-white">@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .custom-input-group-text{
            position: absolute !important;
            top: 16px;
            right: 0;
            height: 37px;
            padding: 10px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group d-flex">
                        <input type="file" name="attachments[]" class="form--control my-3" required />
                        <div class="input-group-append support-input-group">
                            <span class="input-group-text custom-input-group-text btn btn--base border--rounded  remove-btn px-1 py-0">x</span>
                        </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
