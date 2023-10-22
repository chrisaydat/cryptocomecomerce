@php
    $serviceElements = getContent('service.element',false);
@endphp

<section class="info-section section--bg ptb-20">
    <div class="container">
        <div class="info-area">
            <div class="info-slider">
                <div class="swiper-wrapper">
                    @foreach($serviceElements as $item)
                        <div class="swiper-slide">
                            <div class="info-item text-white d-flex flex-wrap justify-content-center align-items-center">
                                <div class="info-icon">
                                    @php echo @$item->data_values->icon @endphp
                                </div>
                                <div class="info-content">
                                    <h4 class="text-white">{{__(@$item->data_values->heading)}}</h4>
                                    <p>{{__(@$item->data_values->sub_title)}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
