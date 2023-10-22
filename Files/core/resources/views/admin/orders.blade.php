@extends('admin.layouts.app')

@section('panel')
<div class="row justify-content-center">

    <div class="col-md-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th>@lang('User')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Order')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $item)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $item->user->fullname }}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $item->user_id) }}"><span>@</span>{{ $item->user->username }}</a>
                                    </span>
                                </td>
                                <td data-label="@lang('Date')">
                                    {{showDateTime($item->created_at)}} <br>
                                    {{diffForHumans($item->created_at)}}
                                </td>
                                <td data-label="@lang('Order')">
                                    <span class="font-weight-bold">{{$general->cur_sym}} {{ $item->sum('total_price') }}</span><br>
                                    {{$item->code}}
                                </td>

                                <td data-label="@lang('Action')">
                                    @if (request()->routeIs('admin.order.processing'))
                                        @if ($item->status == 0)
                                            <a href="javascript:void(0)" class="icon-btn" data-toggle="modal" data-target="#completeModal{{$loop->index}}"><i class="las la-check-circle"></i></a>
                                        @endif
                                    @endif
                                    <a href="{{route('admin.order.details',$item->code)}}" class="icon-btn" data-toggle="tooltip" title="@lang('Order Details')"><i class="las la-info-circle"></i></a>
                                </td>
                                <div id="completeModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">@lang('Make Order Completed Confirmation')</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.order.complete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="code" value="{{$item->code}}">
                                                <div class="modal-body">
                                                    <p>@lang('Are you sure to make this order as completed?')</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                                                    <button type="submit" class="btn btn--primary">@lang('Make Completed')</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage)}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <div class="card-footer py-4">
                {{ paginateLinks($orders) }}
            </div>
        </div><!-- card end -->
    </div>
</div>

@endsection


@push('breadcrumb-plugins')
    <form action="{{route('admin.order.search', $scope ?? str_replace('admin.order.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Code/Product name')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <form action="{{route('admin.order.dateSearch',$scope ?? str_replace('admin.order.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <input type="hidden" name="method" value="{{ @$methodAlias }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush


@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
  <script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush
