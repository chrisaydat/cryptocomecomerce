@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="payment-section ptb-60">
        <div class="container">
            <div class="row">
                @foreach($gatewayCurrency as $data)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <form action="{{route('user.deposit.insert')}}" method="POST">
                            @csrf

                            <input type="hidden" name="currency" value="{{ $data->currency }}">
                            <input type="hidden" name="method_code"  value="{{ $data->method_code }}">
                            <input type="hidden" name="amount"  value="{{$totalPrice}}">

                            <div class="dashboard-area">
                                <h5 class="panel-card-header text-white text-center">{{__($data->name)}}
                                </h5>
                                <div class="panel-card-body section--bg card-body-deposit">
                                    <img src="{{$data->methodImage()}}" class="card-img-top" alt="{{__($data->name)}}" class="w-100">
                                    <ul class="text-center deposit-list">
                                        <li class="text-white">@lang('Total') : <b>{{showAmount($totalPrice)}} {{$general->cur_text}}</b></li>
                                        <li class="text-white">@lang('Charge') : <b>{{ showAmount($data->fixed_charge) }} {{$general->cur_text}} @if($data->percent_charge > 0)+ {{ showAmount($data->percent_charge) }}% @endif</b></li>
                                    </ul>
                                    <div class="panel-card-footer mt-20">
                                        <button class="btn--base w-100" type="submit">
                                            @lang('Pay Now')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
