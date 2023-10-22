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
                                                                <th>@lang('Product Name')</th>
                                                                <th>@lang('Quantity')</th>
                                                                <th>@lang('Unit Price')</th>
                                                                <th>@lang('Total Price')</th>
                                                                <th>@lang('Review')</th>
                                                                <th>@lang('Action')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($orders as $key => $item)
                                                                <tr>
                                                                    <td data-label="@lang('Date')">{{showDateTime($item->created_at,'Y-m-d')}}</td>
                                                                    <td data-label="@lang('Product Name')">{{__($item->product->name)}}</td>
                                                                    <td data-label="@lang('Quantity')">{{__($item->qty)}}</td>
                                                                    <td data-label="@lang('Unit Price')">{{showAmount($item->product_price)}} {{$general->cur_text}}</td>
                                                                    <td data-label="@lang('Total Price')">{{showAmount($item->total_price)}} {{$general->cur_text}}</td>

                                                                    @if ($item->status == 1)
                                                                        @if (!auth()->user()->existedRating($item->product->id))
                                                                            <td data-label="@lang('Review')"><a href="javascript:void(0)" data-id="{{$item->product->id}}" data-toggle="modal" data-target="#reviewModal" class="bg--base px-1 rounded text-white reviewBtn">@lang('Review')</a>
                                                                            </td>
                                                                        @else
                                                                            @php
                                                                                $rating = getRatingByUserProduct(auth()->user()->id, $item->product->id);
                                                                            @endphp
                                                                            <td>
                                                                                <span class="ratings">
                                                                                    @for($i=0; $i < $rating; $i++)
                                                                                        <i class="las la-star"></i>
                                                                                    @endfor
                                                                                    @for($i=0; $i < 5-$rating; $i++)
                                                                                        <i class="lar la-star"></i>
                                                                                    @endfor
                                                                                </span>
                                                                            </td>
                                                                        @endif
                                                                    @else
                                                                        <td>@lang('Not available')</td>
                                                                    @endif

                                                                    <td data-label="@lang('Action')">
                                                                        @if ($item->status == 1 && $item->product->p_file)
                                                                            <p class="badge badge--success text-white"><a href="{{route('user.product.download',Crypt::encrypt($item->product->id))}}" class="fas fa-download"></a></p>
                                                                        @endif
                                                                    </td>
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
                                                {{$orders->links()}}
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

    @if(count($orders) > 0)
        <div class="modal fade" id="reviewModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content py-4">
                    <div class="modal-header">
                        <h4 class="text-white">@lang('Give Your Rating')</h4>
                        <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form action="{{route('user.rating')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="product-single-container">
                                <div class="row mb-30-none">
                                    <div class="col-xl-12 col-md-12 mb-30">

                                        <div class='starrr mb-2' id='star{{ $key }}'></div>
                                        <input type='hidden' name='rating' value='0' id='star2_input' required>
                                        <input type="hidden" name="product_id" value="" required>

                                        <div class="form-group">
                                            <label >@lang('Write your opinion')</label>
                                            <textarea name="review" class="form--control" rows="5" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn--base" data-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn--base">@lang('Yes')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    @endif
@endsection

@push('script')
    <script src="{{asset($activeTemplateTrue.'js/starrr.js')}}"></script>

    <script>

        'use strict';

        $('.reviewBtn').on('click', function () {
            var modal = $('#reviewModal');
            modal.find('input[name=product_id]').val($(this).data('id'));

            var $s2input = $('input[name=rating]');
            var indx = @php echo $orders->count() @endphp;
            var i = 0;
            for (i; i < indx; i++) {
                $(`#star${i}`).starrr({
                    max: 5,
                    rating: $s2input.val(),
                    change: function(e, value){
                        $s2input.val(value).trigger('input');
                    }
                });
            }
        });
    </script>
@endpush
