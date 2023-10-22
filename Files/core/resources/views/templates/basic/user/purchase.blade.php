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

                            <div class="transaction-area mt-30">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                                        <div class="panel-table-area">
                                            <div class="panel-table">
                                                <div class="panel-card-body section--bg table-responsive">
                                                    <table class="custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('Date')</th>
                                                                <th>@lang('Code')</th>
                                                                <th>@lang('Total Price')</th>
                                                                <th>@lang('Paymenet Status')</th>
                                                                <th>@lang('Status')</th>
                                                                <th>@lang('Action')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($products as $key => $item)
                                                                @php
                                                                    $totalPrice = App\Models\Sell::where('code',$item->code)->sum('total_price');
                                                                @endphp

                                                                <tr>
                                                                    <td data-label="@lang('Date')">{{showDateTime($item->created_at,'Y-m-d')}}</td>
                                                                    <td data-label="@lang('Code')">{{$item->code}}</td>
                                                                    <td data-label="@lang('Total Price')">{{$totalPrice}} {{$general->cur_text}}</td>

                                                                    <td data-label="@lang('Paymenet Status')">
                                                                        @if ($item->payment_status == 0)
                                                                            <p class="badge badge--warning text-white">@lang('Pending')</p>
                                                                        @elseif($item->payment_status == 1)
                                                                            <p class="badge badge--success text-white">@lang('Paid')</p>
                                                                        @elseif($item->payment_status == 2)
                                                                            <p class="badge badge--danger text-white">@lang('Rejected')</p>
                                                                        @endif
                                                                    </td>

                                                                    <td data-label="@lang('Status')">
                                                                        @if ($item->status == 0)
                                                                            <p class="badge badge--warning text-white">@lang('Processing')</p>
                                                                        @elseif($item->status == 1)
                                                                            <p class="badge badge--success text-white">@lang('Delivered')</p>
                                                                        @elseif($item->status == 2)
                                                                            <p class="badge badge--warning text-white">@lang('Pending')</p>
                                                                        @elseif($item->status == 3)
                                                                            @php
                                                                                $rejectMessage = App\Models\Deposit::where('code',$item->code)->where('status',3)->pluck('admin_feedback');

                                                                            @endphp

                                                                            <p class="badge badge--danger text-white">@lang('Rejected')</p> <span class="badge badge--danger text-white"><a href="#0" class="las la-info-circle" data-toggle="modal" data-target="#messageModal{{$loop->index}}"></a></span>
                                                                        @endif
                                                                    </td>



                                                                    <td data-label="@lang('Action')">
                                                                        <a href="{{route('user.order.details',$item->code)}}" class="badge badge--success text-white">@lang('Details')</a>
                                                                    </td>

                                                                    <div class="modal fade" id="messageModal{{$loop->index}}">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content py-4">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title text-white">@lang('Rejection Message')</h5>
                                                                                    <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">×</span>
                                                                                    </button>
                                                                                </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="product-single-container">
                                                                                            <div class="row mb-30-none">
                                                                                                <div class="col-xl-12 col-md-12 mb-30">
                                                                                                    <p class="text-white text-center">{{__(@$rejectMessage[0])}}</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn--base" data-dismiss="modal">@lang('Cancel')</button>
                                                                                    </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </tr>

                                                            @empty
                                                                <tr>
                                                                    <td colspan="100%">@lang('No data found')</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <nav>
                                            <ul class="pagination justify-content-end mt-5">
                                                {{$products->links()}}
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
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>

@endsection
