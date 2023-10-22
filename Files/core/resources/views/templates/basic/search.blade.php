@extends($activeTemplate.'layouts.frontend')

@section('content')
    @php
        $offerElements = getContent('home_page_offer.element',false);
    @endphp
    <main class="main-section">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections pb-60">
            @include($activeTemplate.'partials.breadcrumb')

            <div class="container">
                <div class="row mb-30-none">
                    <aside class="sidebar-home col-xl-3 mobile-sidebar mb-30">
                        <div class="aside-inner">
                            <div class="widget widget-range mb-30">
                                <h3 class="widget-range-title">@lang('Filter By Price')</h3>
                                <div class="widget-range-area">
                                    <div id="slider-range"></div>
                                    <div class="price-range">
                                        <label for="amount">@lang('Price') :</label>
                                        <input type="text" id="amount" readonly>
                                        <input type="hidden" name="min_price" value="{{$min}}">
                                        <input type="hidden" name="max_price" value="{{$max}}">
                                    </div>
                                </div>
                            </div>
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
                        </div>
                    </aside>
                    <div class="sidebar-overlay"></div>
                    <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
                    <div class="col-xl-9 mb-30">
                        <nav class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort">
                                    <label>@lang('Sort By') :</label>
                                    <div class="select-custom">
                                        <select name="sortby" class="form-control">
                                            <option value="0">@lang('Sort by Oldest')</option>
                                            <option value="1" selected>@lang('Sort by Newnest')</option>
                                            <option value="2">@lang('Sort by Price: Low to High')</option>
                                            <option value="3">@lang('Sort by Price: High to Low')</option>
                                            <option value="4">@lang('Sort by Rating')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        <div class="main-content">
                            <div class="row mb-30-none">
                                @forelse($products as $item)
                                    <div class="col-xl-4 col-md-6 mb-30">
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

                            <nav>
                                <ul class="pagination justify-content-center mt-5">
                                    {{$products->links()}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>
@endsection

@push('script-lib')
<script src="{{asset($activeTemplateTrue.'js/jquery-ui.min.js')}}"></script>

@endpush

@push('script')
    <!-- jquery -->
    <script>
        'use strict';


        'use strict';
        (function($){
            var searchProduct = null;
            var searchCategory = null;

            @if(request('search_p'))
                searchProduct = '{{request('search_p')}}';
            @endif

            @if(request('search_c') > 0)
                searchCategory = '{{request('search_c')}}';
            @endif

            var sortBy = 1;
            let min = {{$min}};
            let max = {{$max}};

            $("#slider-range").slider({
                range: true,
                min: {{$min}},
                max: {{$max}},
                values: [ {{$min}}, {{$max}} ],

                slide: function( event, ui ) {

                    $( "#amount" ).val( "{{$general->cur_sym}}" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    $('input[name=min_price]').val(ui.values[ 0 ]);
                    $('input[name=max_price]').val(ui.values[ 1 ]);

                },
                change: function(){
                    var min = $('input[name="min_price"]').val();
                    var max = $('input[name="max_price"]').val();
                    counter = 9
                    getFilteredData(min, max, sortBy, searchProduct, searchCategory);
                }
            });

            $( "#amount" ).val("{{$general->cur_sym}}" + {{$min}} + " - {{$general->cur_sym}}" + {{$max}});

            $('select[name="sortby"]').on('change', function(){
                sortBy = $('select[name="sortby"]').find(":selected").val();

                min = $('input[name=min_price]').val();
                max = $('input[name=max_price]').val();
                counter = 9;
                getFilteredData(min, max, sortBy, searchProduct, searchCategory);
            });

            function getFilteredData(min, max, sortBy, searchProduct, searchCategory){

                $.ajax({
                    type: "get",
                    url: "{{ route('product.filtered') }}",
                    data:{
                        "min": min,
                        "max": max,
                        "sortby": sortBy,
                        "search_p": searchProduct,
                        "search_c": searchCategory
                    },

                    dataType: "json",
                    success: function (response) {

                        if(response.html){
                            $('.main-content').html(response.html);
                        }else{
                            $.each(response.html, function (i, val) {
                                notify('error',val);
                            });
                        }
                    }
                });
            }

            var counter = 9;
            var path = `{{ asset(imagePath()['p_image']['path']) }}`;

            $(document).on('click', '#loadMoreBtn' ,function () {

                sortBy = $('select[name="sortby"]').find(":selected").val();

                min = $('input[name=min_price]').val();
                max = $('input[name=max_price]').val();

                $.ajax({
                    type: "get",
                    url: "{{ route('loadmore.products') }}",
                    data:{count:counter,min:min,max:max,sortby:sortBy},
                    dataType: "json",

                    success: function (response) {
                        if (response.productCount < 9) {
                            $('#loadMoreBtn').remove();
                        }

                        if(response.html){
                            $('.product-list').append(response.html);
                        }

                        counter = parseInt(counter) + 9;
                    }
                });
            });

        })(jQuery)

    </script>
@endpush
