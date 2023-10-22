@foreach($products as $item)
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

                <button data-toggle="modal" class="btn-quickview quick-view" data-resource="{{$item}}" data-id="{{Crypt::encrypt($item->id)}}" data-image="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->image[0],imagePath()['p_image']['size']) }}">  @lang('Quick View')  </button>

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
@endforeach
