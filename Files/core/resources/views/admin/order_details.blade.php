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
                            <th>@lang('Date')</th>
                            <th>@lang('User')</th>
                            <th>@lang('Product Name')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Unit Price')</th>
                            <th>@lang('Total Price')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orderDetails as $item)
                            <tr>
                                <td data-label="@lang('Date')">
                                    {{showDateTime($item->created_at,'Y-m-d')}}
                                </td>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $item->user->fullname }}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $item->user_id) }}"><span>@</span>{{ $item->user->username }}</a>
                                    </span>
                                </td>
                                <td data-label="@lang('Product Name')">
                                    {{$item->product->name}}
                                </td>
                                <td data-label="@lang('Quantity')">
                                    {{$item->qty}}
                                </td>
                                <td data-label="@lang('Unit Price')">
                                    {{$item->product_price}}
                                </td>
                                <td data-label="@lang('Total Price')">
                                    {{$item->total_price}}
                                </td>
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
        </div><!-- card end -->
    </div>
</div>

@if (@$shippingAddress[0] == null)

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-12 col-md-12 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Shipping Address')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="font-weight-bold">{{@$shippingAddress[0]->name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Contact No')
                            <span class="font-weight-bold">{{@$shippingAddress[0]->mobile}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="font-weight-bold">{{@$shippingAddress[0]->email}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Address')
                            <span class="font-weight-bold">{{@$shippingAddress[0]->address}}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

