@extends($activeTemplate.'layouts.frontend')

@section('content')

    <main class="main-section">
        <section class="all-sections pb-60">

            @include($activeTemplate.'partials.breadcrumb')

            <div class="container">
                <div class="row mb-30-none">

                    @include($activeTemplate.'user.partials.sidenav')

                    <div class="col-xl-9 mb-30">
                        <div class="body-wrapper">

                            @include($activeTemplate.'user.partials.dashboard_header')

                            <div class="transaction-area mt-30">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                                        <div class="panel-table-area">
                                            <div class="ticket-header">
                                                <a href="{{route('ticket.open') }}" class="btn--base border--rounded float-right mb-3"><i class="fa fa-plus"></i>   @lang('New Ticket')
                                                </a>
                                            </div>
                                            <div class="panel-table">
                                                <div class="panel-card-body section--bg table-responsive">
                                                    <table class="custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('Subject')</th>
                                                                <th>@lang('Status')</th>
                                                                <th>@lang('Priority')</th>
                                                                <th>@lang('Last Reply')</th>
                                                                <th>@lang('Action')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($supports as $key => $support)
                                                                <tr>
                                                                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                                                    <td data-label="@lang('Status')">
                                                                        @if($support->status == 0)
                                                                            <span class="badge badge--success">@lang('Open')</span>
                                                                        @elseif($support->status == 1)
                                                                            <span class="badge badge--primary">@lang('Answered')</span>
                                                                        @elseif($support->status == 2)
                                                                            <span class="badge badge--warning">@lang('Customer Reply')</span>
                                                                        @elseif($support->status == 3)
                                                                            <span class="badge badge--dark">@lang('Closed')</span>
                                                                        @endif
                                                                    </td>
                                                                    <td data-label="@lang('Priority')">
                                                                        @if($support->priority == 1)
                                                                            <span class="badge badge--dark">@lang('Low')</span>
                                                                        @elseif($support->priority == 2)
                                                                            <span class="badge badge--success">@lang('Medium')</span>
                                                                        @elseif($support->priority == 3)
                                                                            <span class="badge badge--primary">@lang('High')</span>
                                                                        @endif
                                                                    </td>
                                                                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                                                    <td data-label="@lang('Action')">
                                                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn--base px-2 py-0 border--rounded">
                                                                            <i class="fa fa-desktop"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <nav>
                                            <ul class="pagination justify-content-end mt-5">
                                                {{$supports->links()}}
                                            </ul>
                                        </nav>
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
