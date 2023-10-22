@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="banner-section ptb-30">
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-xl-9 col-lg-9 mb-30">
                    <div class="banner-slider">
                        <div class="swiper-wrapper">
                            @foreach ($bannerElements as $item)
                                <div class="swiper-slide">
                                    <div class="banner-thumb-area">
                                        <div class="banner-thumb">
                                            <img src="{{ getImage('assets/images/frontend/banner/'. @$item->data_values->image,'835x445') }}" alt="@lang('banner')">
                                        </div>
                                        <div class="banner-content">
                                            <h3 class="sub-title text-white">{{__(@$item->data_values->upper_title)}}</h3>
                                            <h1 class="title text-white">{{__(@$item->data_values->heading)}}</h1>
                                            <h5 class="text-white d-inline-block mb-0 align-top mr-4 pt-2">{{__(@$item->data_values->bottom_title)}}</h5>
                                            <a href="{{@$item->data_values->url}}" class="btn--base active">{{__(@$item->data_values->button_name)}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 mb-30">
                    <div class="row justify-content-center mb-10-none">
                        <div class="col-xl-12 col-lg-12 col-md-6 mb-10">
                            <div class="banner-right-thumb">
                                <figure>
                                    @php echo advertisements('265x135') @endphp
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6 mb-10">
                            <div class="banner-right-thumb">
                                <figure>
                                    @php echo advertisements('265x135') @endphp
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6 mb-10">
                            <div class="banner-right-thumb">
                                <figure>
                                    @php echo advertisements('265x135') @endphp
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
