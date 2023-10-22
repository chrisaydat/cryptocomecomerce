@extends($activeTemplate.'layouts.frontend')

@section('content')

    <div class="ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="dashboard-area">
                        <div class="panel-card-header text-center section--bg p-3">
                            <h4 class="mb-0 text-white">@lang('Payment Preview')</h4>
                        </div>
                        <div class="panel-card-body card-body-deposit text-center">
                            <h4 class="my-2 text-white"> @lang('PLEASE SEND EXACTLY') <span class="text--base"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                            <h5 class="mb-2 text-white">@lang('TO') <span class="text--base"> {{ $data->sendto }}</span></h5>
                            <img src="{{$data->img}}" alt="@lang('Image')">
                            <h4 class="text-white bold my-4 section--bg p-2 border--base">@lang('SCAN TO SEND')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
