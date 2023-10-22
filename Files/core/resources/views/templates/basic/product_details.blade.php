@extends($activeTemplate.'layouts.frontend')

@section('content')
    <main class="main">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections">
            @include($activeTemplate.'partials.breadcrumb')
            <div class="container">
                <div class="row mb-30-none">
                    <div class="col-xl-9 mb-30">
                        <div class="product-single-container">
                            <div class="row mb-30-none">
                                <div class="col-xl-5 col-md-6 mb-30">
                                    <div class="xzoom-container">
                                        <img class="xzoom5" id="xzoom-magnific" alt="@lang('image')" src="{{ getImage(imagePath()['p_image']['path'] .'/'.$product->image[0],imagePath()['p_image']['size']) }}"
                                            xoriginal="{{ getImage(imagePath()['p_image']['path'] .'/'.$product->image[0],imagePath()['p_image']['size']) }}" />
                                        <div class="xzoom-thumbs mt-10">
                                            <div class="product-single-slider">
                                                <div class="swiper-wrapper">
                                                    @foreach($product->image as $item)
                                                        <div class="swiper-slide">
                                                            <a href="{{ getImage(imagePath()['p_image']['path'] .'/'.$item,imagePath()['p_image']['size']) }}">
                                                                <img class="xzoom-gallery5" alt="image"
                                                                    src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item,imagePath()['p_image']['size']) }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-7 col-md-6 mb-30">
                                    <div class="product-details-content">
                                        <h2 class="product-title text-white">{{__($product->name)}}</h2>
                                        <div class="ratings-container d-flex flex-wrap align-items-center">
                                            <div class="product-ratings">
                                                <span class="ratings">
                                                    @for($i=0; $i < $product->avg_rating; $i++)
                                                        <i class="las la-star"></i>
                                                    @endfor
                                                    @for($i=0; $i < 5-$product->avg_rating; $i++)
                                                        <i class="lar la-star"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                            <a href="javascript:void(0)" class="rating-link">( {{count($product->ratings)}} @lang('Reviews') )</a>
                                        </div>
                                        <hr class="short-divider">
                                        <div class="price-box">
                                            <span class="product-price">{{$general->cur_sym}}{{showAmount($product->new_price)}}</span>
                                        </div>

                                        <div class="product-desc mb-2">
                                            <p>
                                                {{__($product->short_description)}}
                                            </p>
                                        </div>
                                        <form>
                                            <div class="product-action d-flex flex-wrap align-items-center">
                                                <div class="product-quantity">
                                                    <div class="product-plus-minus">
                                                        <div class="dec qtybutton">-</div>
                                                        <input class="product-plus-minus-box integer-validation" id="product-qty" type="text" name="qty" value="1">
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn--base add-cart icon-shopping-cart productAddtocart" title="Add to Cart">@lang('Add to Cart')</button>
                                            </div>
                                        </form>
                                        <div class="product-single-share d-flex flex-wrap align-items-center">
                                            <label class="sr-only">@lang('Share'):</label>
                                            <div class="social-icons mr-2">

                                                <a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug($product->name)}}" class="social-icon social-facebook" target="_blank" title="@lang('Facebook')"><i
                                                        class="lab la-facebook-f"></i></a>
                                                <a href="http://twitter.com/share?text={{slug($product->name)}}&url={{urlencode(url()->current()) }}" class="social-icon social-twitter" target="_blank" title="@lang('Twitter')"><i
                                                        class="lab la-twitter"></i></a>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug($product->name)}}" class="social-icon social-linkedin" target="_blank" title="@lang('Linkedin')"><i
                                                        class="lab la-linkedin-in"></i></a>
                                                <a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug($product->name)}}" class="social-icon social-gplus" target="_blank" title="@lang('Pinterest') +"><i class="lab la-pinterest-p"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-single-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab"
                                        aria-controls="product-desc-content" aria-selected="true">@lang('Description')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab"
                                        aria-controls="product-reviews-content" aria-selected="false">@lang('Reviews') ({{count($product->ratings)}})</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                    <div class="product-desc-content">
                                        @php echo $product->description @endphp
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                    <div class="product-reviews-content">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h3 class="reviews-title">{{count($product->ratings)}} @lang('reviews for') {{__($product->name)}}</h3>
                                                <ul class="comment-list">
                                                    @foreach ($ratings->take(5) as $item)
                                                        <li class="comment-container d-flex flex-wrap">
                                                            <div class="comment-avatar">
                                                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $item->user->image,imagePath()['profile']['user']['size']) }}" alt="avatar">
                                                            </div>
                                                            <div class="comment-box">
                                                                <div class="ratings-container">
                                                                    <div class="product-ratings">
                                                                        @for($i=0; $i < $item->rating; $i++)
                                                                            <i class="las la-star"></i>
                                                                        @endfor
                                                                        @for($i=0; $i < 5-$item->rating; $i++)
                                                                            <i class="lar la-star"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="comment-info mb-1">
                                                                    <h4 class="avatar-name">{{$item->user->fullname}}</h4> - <span class="comment-date">{{showDateTime($item->created_at,'F d,Y')}}</span>
                                                                </div>
                                                                <div class="comment-text">
                                                                    <p>{{__($item->review)}}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @if (count($ratings) > 5)
                                                    <div class="text-center">
                                                        <button type="button" class="btn--base add-cart icon-shopping-cart mt-4" id="loadMoreBtn">@lang('Load More')</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <aside class="sidebar-home col-xl-3 mobile-sidebar mb-30">
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
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>

    <section class="product-section ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="section-header">
                        <h3 class="section-title">@lang('Related Products')</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="product-slider-two">
                        <div class="swiper-wrapper">
                            @foreach($product->category->products()->where('status',1)->latest()->limit(12)->with('subcategory')->get() as $item)
                                <div class="swiper-slide">
                                    <div class="product-default">
                                        <figure>
                                            <a href="{{route('product.details',[$item->id,slug($item->name)])}}">
                                                <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}" alt="@lang('product')">
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
                                                    <a href="javascript:void(0)" class="product-category">{{__($item->subcategory->name)}}</a>
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('shareImage')
    {{--<!-- Google / Search Engine Tags -->--}}
    <meta itemprop="name" content="{{ __($product->name) }}">
    <meta itemprop="description" content="{{ __($product->short_description) }}">
    <meta itemprop="image" content="{{ getImage(imagePath()['p_image']['path'] .'/'.$product->image[0],imagePath()['p_image']['size']) }}">

    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:image" content="{{ getImage(imagePath()['p_image']['path'] .'/'.$product->image[0],imagePath()['p_image']['size']) }}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __($product->name) }}">
    <meta property="og:description" content="{{ __($product->short_description) }}">
    <meta property="og:image:type" content="{{ getImage(imagePath()['p_image']['path'] .'/'.$product->image[0],imagePath()['p_image']['size']) }}" />
    @php $social_image_size = explode('x', imagePath()['p_image']['size']) @endphp
    <meta property="og:image:width" content="{{ $social_image_size[0] }}" />
    <meta property="og:image:height" content="{{ $social_image_size[1] }}" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush



@push('script')
<script>
    'use strict';

    (function ($) {

        var counter = 5;

        $('#loadMoreBtn').on('click', function() {
            $.ajax({
                type: "get",
                url: "{{ route('loadmore.rating') }}",
                data:{count:counter,id:'{{$product->id}}'},
                dataType: "json",
                success: function (response) {

                    if (response.ratings.length < 5) {
                        $('#loadMoreBtn').remove();
                    }

                    if(response.html){
                        $('.comment-list').append(response.html);
                    }

                    counter = parseInt(counter) + parseInt(5);
                }
            });
        });


    })(jQuery);

    $('.productAddtocart').on('click',function () {

        var id = '{{$product->id}}';
        var pQty = $('#product-qty').val();
        var csrf = '{{csrf_token()}}'

        $.ajax({
            type: "post",
            url: "{{ route('addtocart') }}",
            data:{product_id:id,qty:pQty, _token:csrf},
            dataType: "json",


            success: function (response) {
                if(response.success){

                    notify('success', response.success);
                    $(document).find('.total-cart').text(response.cartCount);
                    $(document).find('.total-price').text(response.totalPrice);
                    $('.dropdown-cart-products').html('');
                    $('.dropdown-cart-products').html(response.html);

                    if (response.cartCount > 0) {

                        var checkoutHtml = `<div class="dropdown-cart-action">
                                                <a href="{{route('cart')}}" class="btn--base w-100">@lang('Checkout')</a>
                                            </div>`;
                        $('.checkout-btn').html(checkoutHtml);
                    }

                }else{
                    notify('error', response.error);
                }
            }
        });
    });
</script>
@endpush

