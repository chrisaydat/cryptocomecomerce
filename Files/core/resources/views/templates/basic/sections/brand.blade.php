@php
    $brandContent = getContent('brand.content',true);
    $brandElements = getContent('brand.element',false);
@endphp
<section class="product-brand-section ptb-60">
    <div class="container">
        <div class="row mb-30-none">
            <div class=" col-lg-3 col-sm-6 col-6 mb-30">
                <div class="brand-banners text-center">
                    <div class="brand-side-banner">
                        <figure>
                            @php echo advertisements('265x330') @endphp
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-sm-6 col-6 mb-30">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="brand-slider">
                            <div class="swiper-wrapper">
                                @foreach ($brandElements as $item)
                                    @if($loop->odd)
                                        <div class="swiper-slide">
                                            <div class="brand-item">
                                                <img src="{{ getImage('assets/images/frontend/brand/'. @$item->data_values->image,'170x100') }}" alt="@lang('brand')">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="brand-slider-two">
                            <div class="swiper-wrapper">
                                @foreach ($brandElements as $item)
                                    @if ($loop->even)
                                        <div class="swiper-slide">
                                            <div class="brand-item">
                                                <img src="{{ getImage('assets/images/frontend/brand/'. @$item->data_values->image,'170x100') }}" alt="@lang('brand')">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
