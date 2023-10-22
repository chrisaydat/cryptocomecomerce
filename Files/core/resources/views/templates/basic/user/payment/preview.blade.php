@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="payment-section payment-preview-section ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="payment-item d-flex flex-wrap align-items-center justify-content-between">
                        <div class="payment-thumb">
                            <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('payment')">
                        </div>
                        <div class="payment-content">
                            <ul class="payment-list">
                                <li><span> @lang('Amount')</span> - {{showAmount($data->amount)}} {{__($general->cur_text)}}</li> </strong>
                                <li><span> @lang('Charge')</span> - {{showAmount($data->charge)}} {{__($general->cur_text)}}</li>
                                <li><span> @lang('Payable')</span> - {{showAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}</li>
                            </ul>
                            <div class="payment-btn">
                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="btn--base">@lang('Pay Now')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="btn--base">@lang('Pay Now')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


