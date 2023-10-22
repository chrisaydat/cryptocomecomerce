@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="payment-confirm ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="dashboard-area">
                        <div class="panel-card-header section--bg">
                            <h4 class="text-white mb-0 p-1">{{__($pageTitle)}}</h4>
                        </div>
                        <div class="panel-card-body text-white">
                            <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p class="text-center text-white mt-2">@lang('Please pay Exactly')
                                            <b class="text-success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('To confirm the order')
                                        </p>
                                        <h4 class="text-center text-white mb-4">@lang('Please follow the instruction below')</h4>

                                        <p class="my-4 text-center text-white">@php echo  $data->gateway->description @endphp</p>

                                    </div>

                                    @if($method->gateway_parameter)

                                        @foreach(json_decode($method->gateway_parameter) as $k => $v)

                                            @if($v->type == "text")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <input type="text" class="form--control" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}">
                                                    </div>
                                                </div>
                                            @elseif($v->type == "textarea")
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                            <textarea name="{{$k}}"  class="form--control"  placeholder="{{__($v->field_level)}}" rows="3">{{old($k)}}</textarea>

                                                        </div>
                                                    </div>
                                            @elseif($v->type == "file")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>

                                                        <input type="file" class="form--control" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="submit-btn mt-2">@lang('Pay Now')</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
