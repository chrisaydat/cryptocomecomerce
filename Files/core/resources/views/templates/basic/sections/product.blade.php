@php
    $products = App\Models\Product::where('status',1)->latest()->limit(12)->with('subcategory')->get();
    $featuredProducts = App\Models\Product::where('status',1)->where('featured',1)->latest()->limit(9)->with('subcategory')->get();
    $offerElements = getContent('home_page_offer.element',false);
    $subscriberElements = getContent('subscribe.content',true);

    $categoryData = App\Models\Category::with(['subcategories','products'=>function($q){
        $q->where('status',1)->limit(9);
    }, 'products.subcategory'])->latest()->get();
@endphp

<main class="main-section">
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start All-sections
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="all-sections ptb-60">
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-xl-9 col-lg-9 mb-30">
                    <div class="hot-deal pb-40">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="section-header">
                                    <h3 class="section-title">@lang('Product Collection')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product-slider">
                                    <div class="swiper-wrapper">
                                        @forelse($products as $item)

                                            <div class="swiper-slide">
                                                <div class="product-default">
                                                    <figure>
                                                        <a href="{{route('product.details',[$item->id,slug($item->name)])}}">
                                                            <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}" alt="@lang('product-image')">
                                                        </a>

                                                        @if ($item->featured == 1)
                                                            <div class="label-group">
                                                                <span class="product-label label-sale">@lang('Featured')</span>
                                                            </div>
                                                        @endif

                                                        <button data-toggle="modal" class="btn-quickview quick-view" data-resource="{{$item}}" data-image="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}">  @lang('Quick View')  </button>

                                                    </figure>
                                                    <div class="product-details d-flex flex-wrap align-items-start">
                                                        <div
                                                            class="category-wrap d-flex flex-wrap justify-content-between align-items-center w-100">
                                                            <div class="category-list">
                                                                <a href="{{route('subcategory.search',$item->subcategory->id)}}" class="product-category">{{__($item->subcategory->name)}}</a>
                                                            </div>

                                                        </div>
                                                        <h3 class="product-title">
                                                            <a href="{{route('product.details',[$item->id, slug($item->name)])}}">{{__($item->name)}}</a>
                                                        </h3>
                                                        <div class="ratings-container">
                                                            <div class="product-ratings">
                                                                <span class="ratings">
                                                                    @php echo displayRating($item->avg_rating) @endphp
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="price-box">
                                                            @if ($item->old_price)
                                                                <span class="old-price">{{$general->cur_sym}}{{showAmount($item->old_price)}}</span>
                                                            @endif
                                                            <span class="product-price">{{$general->cur_sym}}{{showAmount($item->new_price)}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-xl-4 col-md-6 mb-30">
                                                <div class="product-default">
                                                    <div class="product-details d-flex flex-wrap align-items-start">
                                                        <h3 class="product-title">
                                                            @lang('No data found')
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banners-group pb-40">
                        <div class="row mb-30-none">
                            <div class="col-md-6 mb-30">
                                <div class="product-banner">
                                    <figure>
                                        @php echo advertisements('580x240') @endphp
                                    </figure>

                                </div>
                            </div>
                            <div class="col-md-6 w-md-55 mb-30">
                                <div class="product-banner">
                                    <figure>
                                        @php echo advertisements('580x240') @endphp
                                    </figure>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="featured-products-tab" data-toggle="tab"
                                    href="#featured-products" role="tab" aria-controls="featured-products"
                                    aria-selected="true">@lang('Featured Products')</a>
                            </li>
                            @foreach ($categories->take(6) as $item)
                                <li class="nav-item">
                                    <a class="nav-link" id="{{str_replace(' ','_',strtolower($item->name))}}-tab" data-toggle="tab" href="#{{str_replace(' ','_',strtolower($item->name))}}"
                                        role="tab" aria-controls="{{str_replace(' ','_',strtolower($item->name))}}" aria-selected="false">{{__($item->name)}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel"
                                aria-labelledby="featured-products-tab">
                                <div class="row mb-30-none">
                                    @forelse($featuredProducts as $item)
                                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                            <div class="product-default">
                                                <figure>
                                                    <a href="{{route('product.details',[$item->id,slug($item->name)])}}">
                                                        <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}" alt="@lang('product')">
                                                    </a>

                                                    <button data-toggle="modal" class="btn-quickview quick-view" data-resource="{{$item}}" data-image="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}">  @lang('Quick View')  </button>

                                                </figure>
                                                <div class="product-details d-flex flex-wrap align-items-start">
                                                    <div class="category-wrap d-flex flex-wrap justify-content-between align-items-center w-100">
                                                        <div class="category-list">
                                                            <a href="{{route('subcategory.search',$item->subcategory->id)}}" class="product-category">{{__($item->subcategory->name)}}</a>
                                                        </div>

                                                    </div>
                                                    <h3 class="product-title">
                                                        <a href="{{route('product.details',[$item->id,slug($item->name)])}}">{{__($item->name)}}</a>
                                                    </h3>
                                                    <div class="ratings-container">
                                                        <div class="product-ratings">
                                                            <span class="ratings">
                                                                @php echo displayRating($item->avg_rating) @endphp
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="price-box">
                                                        @if ($item->old_price)
                                                            <span class="old-price">{{$general->cur_sym}}{{showAmount($item->old_price)}}</span>
                                                        @endif
                                                        <span class="product-price">{{$general->cur_sym}}{{showAmount($item->new_price)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-xl-4 col-md-6 mb-30">
                                            <div class="product-default">
                                                <div class="product-details d-flex flex-wrap align-items-start">
                                                    <h3 class="product-title">
                                                        @lang('No data found')
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            @foreach ($categoryData->take(6) as $data)
                                <div class="tab-pane fade" id="{{str_replace(' ','_',strtolower($data->name))}}" role="tabpanel"
                                    aria-labelledby="{{str_replace(' ','_',strtolower($data->name))}}-tab">
                                    <div class="row mb-30-none">

                                        @forelse ($data->products as $item)
                                            <div class="col-xl-4 col-md-6 mb-30">
                                                <div class="product-default">
                                                    <figure>
                                                        <a href="{{route('product.details',[$item->id,slug($item->name)])}}">
                                                            <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}" alt="@lang('product')">
                                                        </a>

                                                        <button data-toggle="modal" class="btn-quickview quick-view" data-resource="{{$item}}" data-image="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}">  @lang('Quick View') </button>
                                                    </figure>
                                                    <div class="product-details d-flex flex-wrap align-items-start">
                                                        <div class="category-wrap d-flex flex-wrap justify-content-between align-items-center w-100">
                                                            <div class="category-list">
                                                                <a href="{{route('subcategory.search',$item->subcategory->id)}}" class="product-category">{{__($item->subcategory->name)}}</a>
                                                            </div>
                                                        </div>
                                                        <h3 class="product-title">
                                                            <a href="{{route('product.details',[$item->id,slug($item->name)])}}">{{__($item->name)}}</a>
                                                        </h3>
                                                        <div class="ratings-container">
                                                            <div class="product-ratings">
                                                                <span class="ratings">
                                                                    @php echo displayRating($item->avg_rating) @endphp
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="price-box">
                                                            @if ($item->old_price)
                                                                <span class="old-price">{{$general->cur_sym}}{{showAmount($item->old_price)}}</span>
                                                            @endif
                                                                <span class="product-price">{{$general->cur_sym}}{{showAmount($item->new_price)}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-xl-4 col-md-6 mb-30">
                                                <div class="product-default">
                                                    <div class="product-details d-flex flex-wrap align-items-start">
                                                        <h3 class="product-title">
                                                            @lang('No data found')
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <aside class="sidebar-home col-xl-3 col-lg-3 mobile-sidebar mb-30">
                    <div class="aside-inner">
                        <div class="side-menu-wrapper mb-30">
                            <h3 class="side-menu-title">@lang('Categories')</h3>
                            <ul class="side-menu pt-2 mb-2 px-2 mx-3">
                                @forelse($categories as $item)
                                    <li class="has-sub">
                                        <a href="javascript:void(0)">{{__($item->name)}}</a>

                                        @if (count($item->subcategories) > 0)
                                            <span class="side-menu-toggle"></span>

                                            <ul>
                                                @foreach ($item->subcategories as $data)
                                                    <li><a href="{{route('subcategory.search',$data->id)}}">{{__($data->name)}}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @empty
                                    <li class="text-white">@lang('No data found')</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="widget widget-banners px-4 pb-4 text-center mb-30">
                            <div class="widget-slider">
                                <div class="swiper-wrapper">

                                    @foreach ($offerElements  as $item)
                                        <div class="swiper-slide">
                                            <div class="side-banner d-flex flex-column align-items-center">
                                                <h3
                                                    class="badge-sale bg--base d-flex flex-column align-items-center justify-content-center text-uppercase">
                                                    <em class="pt-2">{{__(@$item->data_values->heading)}}</em>{{__(@$item->data_values->sub_title)}}
                                                </h3>
                                                <h4 class="sale-text font1 text-uppercase m-b-3">{{__(@$item->data_values->discount)}}<sup>%</sup><sub>@lang('off')</sub>
                                                </h4>
                                                <p>{{__(@$item->data_values->details)}}</p>
                                                <a href="{{__(@$item->data_values->url)}}" class="btn btn--base btn-md">@lang('View Sale')</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="widget widget-newsletters bg-gray text-center mb-30">
                            <h3 class="widget-title text-uppercase">{{@$subscriberElements->data_values->heading}}</h3>
                            <p class="mb-2">{{@$subscriberElements->data_values->sub_title}} </p>
                            <form>
                                <div class="form-group position-relative envolope-letter mb-0">
                                    <input type="email" id="subscriber" class="form-control" name="email" placeholder="@lang('Email address')">
                                    <button type="button" class="btn--base mt-20 subs">@lang('Subscribe')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>
                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End All-sections
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
</main>



@push('script')
    <script>
        'use strict';

        (function ($) {
            $('.subs').on('click',function () {
                var email = $('#subscriber').val();
                var csrf = '{{csrf_token()}}'
                var url = "{{ route('subscriber.store') }}";
                var data = {email:email, _token:csrf};

                $.post(url, data,function(response){
                    if(response.success){
                        notify('success', response.success);
                        $('#subscriber').val('');
                    }else{
                        notify('error', response.error);
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
