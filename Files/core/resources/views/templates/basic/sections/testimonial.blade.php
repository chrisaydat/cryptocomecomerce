@php
    $testimonialElements = getContent('testimonial.element',false);
@endphp

<section class="client-section ptb-60 section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="client-slider">
                    <div class="swiper-wrapper">
                        @foreach($testimonialElements as $item)
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-content text-center">
                                        <div class="client-quote-icon">
                                            <i class="las la-quote-right"></i>
                                        </div>
                                        <p>{{__(@$item->data_values->quote)}}</p>
                                    </div>
                                    <div class="client-thumb-area d-flex flex-wrap justify-content-center align-items-center">
                                        <div class="client-thumb">
                                            <img src="{{ getImage('assets/images/frontend/testimonial/'. @$item->data_values->image,'100x100') }}" alt="client">
                                        </div>
                                        <div class="client-thumb-content">
                                            <h3 class="title">{{__(@$item->data_values->name)}}</h3>
                                            <span class="sub-title">{{__(@$item->data_values->designation)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
