@php
    $headerContent = getContent('header.content',true);
@endphp

<div class="page-wrapper">
    <div class="top-notice text-white bg--base">
        <div class="container text-center">
            <h5 class="d-inline-block mb-0 mr-2 text-white">{{__(@$headerContent->data_values->top_message_one)}}</h5>
            <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        </div>
    </div>

    <header class="header-section">
        <div class="header">
            <div class="header-top-area">
                <div class="container">
                    <div class="header-top-content-area d-flex flex-wrap align-items-center justify-content-between">
                        <div class="header-top-left d-flex flex-wrap align-items-center">
                            <div class="header-dropdown">
                                <select class="language-select langSel rounded">
                                    @foreach($language as $item)
                                        <option class="bg-dark" value="{{ __($item->code) }}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="header-top-right d-flex flex-wrap align-items-center">
                            <p class="top-message text-uppercase d-none d-sm-block text-white mb-0">{{__(@$headerContent->data_values->top_message_two)}}</p>
                            <span class="separator"></span>
                            <div class="header-dropdown dropdown-expanded mx-3 px-1">
                                <a href="javascript:void(0)">@lang('Links')</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a href="{{route('home')}}">@lang('Home')</a></li>
                                        <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                                        <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>

                                        @auth
                                            <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
                                        @else
                                            <li><a href="javascript:void(0)" class="login-link account-open-btn">@lang('Login/Register')</a></li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                            <span class="separator"></span>
                            <div class="header-social">
                                @foreach ($socialElements as $item)
                                    <a href="{{@$item->data_values->url}}">@php echo @$item->data_values->social_icon @endphp</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle-area">
                <div class="container">
                    <div class="header-middle-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="header-middle-left d-flex flex-wrap align-items-center col-lg-2 w-auto pl-0 mr-3">
                            <button class="mobile-menu-toggler" type="button">
                                <i class="las la-bars"></i>
                            </button>
                            <a href="{{route('home')}}" class="@lang('logo')">
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="@lang('logo')">
                            </a>
                        </div>
                        <div class="header-right w-lg-max d-flex flex-wrap align-items-center ml-auto">
                            <div
                                class="header-icon header-search header-search-inline header-search-category mr-lg-2 pr-lg-4 w-lg-max">
                                <a href="javascript:void(0)" class="search-toggle" role="button"><i class="las la-search"></i></a>
                                <form action="{{ route('product.search')}}" method="get">
                                    <div class="header-search-wrapper">
                                        <input type="search" class="form-control" name="search_p" value="{{ request()->search_p??null }}" id="q" placeholder="@lang('Search')...">
                                        <div class="select-custom body-text">
                                            <select id="cat" name="search_c">
                                                <option value="0">@lang('All')</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn" type="submit"><i class="las la-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div class="header-contact d-none d-xl-flex pl-1 mr-xl-2 pr-4">
                                @php echo @$headerContent->data_values->contact_icon @endphp
                                <h6>{{__(@$headerContent->data_values->contact_heading)}}<a href="tel:{{ $headerContent->data_values->contact_details }}">{{__(@$headerContent->data_values->contact_details)}}</a></h6>
                            </div>

                            @auth
                                <a href="{{route('user.home')}}" class="header-icon icon--style pl-1"><i class="las la-user-circle"></i></a>
                            @else

                                <a href="javascript:void(0)" class="header-icon icon--style login-link account-open-btn pl-1"><i class="las la-user-circle"></i></a>
                            @endauth

                           @if (!(request()->routeIs('cart') || request()->routeIs('user.deposit*')))
                                <div class="dropdown cart-dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle dropdown-arrow icon--style" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                        <i class="las la-shopping-bag"></i>
                                        <span class="cart-count badge-circle">
                                            @php
                                                if(auth()->user()){
                                                    $ordersCount = auth()->user()->myOrder()->with('product')->get();
                                                }else{
                                                    $ordersCount = App\Models\Order::where('order_number',session()->get('order_number'))->with('product')->get();
                                                }
                                            @endphp
                                            <span class="total-cart">{{count($ordersCount)}}</span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdownmenu-wrapper">
                                            <div class="dropdown-cart-header">
                                                <span class="total-cart">{{count($ordersCount)}}</span> <span>@lang('Items')</span>
                                            </div>
                                            <div class="dropdown-cart-products">
                                                @foreach ($ordersCount as $item)

                                                    <div class="product remove-data">
                                                        <div class="product-details">
                                                            <h4 class="product-title">
                                                                <a href="javascript:void(0)">{{__($item->product->name)}}</a>
                                                            </h4>
                                                            <span class="cart-product-info">
                                                                <span class="cart-product-qty">{{$item->qty}}</span>
                                                                x {{$general->cur_sym}}{{$item->product->new_price}}
                                                            </span>
                                                        </div>
                                                        <figure class="product-image-container">
                                                            <a href="javascript:void(0)" class="product-image">
                                                                <img src="{{ getImage(imagePath()['p_image']['path'] .'/'.$item->product->image[0],imagePath()['p_image']['size']) }}" alt="product">
                                                            </a>
                                                            <a href="javascript:void(0)" class="btn-remove remove-cart" data-id="{{Crypt::encrypt($item->id)}}" title="@lang('Remove Product')"><i class="las la-times"></i>
                                                            </a>
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="dropdown-cart-total">
                                                <span>@lang('Total')</span>
                                                <span class="total-price float-right">{{$general->cur_sym}}{{ $ordersCount->sum('total_price') }}</span>
                                            </div>
                                            <div class="checkout-btn">
                                                @if (count($ordersCount) > 0)
                                                    <div class="dropdown-cart-action">
                                                        <a href="{{route('cart')}}" class="btn--base w-100">@lang('Go To Cart')</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-bottom-area">
                <div class="container">
                    <div class="header-menu-content">
                        <nav class="navbar navbar-expand-lg p-0">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav main-menu mr-auto">
                                    <li><a href="{{route('home')}}">@lang('Home')</a></li>
                                    <li><a href="{{route('products')}}">@lang('Products')</a></li>
                                    @foreach($pages as $k => $data)
                                        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                                    @endforeach
                                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                                    <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mobile-menu-overlay"></div>

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="las la-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active"><a href="{{route('home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('products')}}">@lang('Products')</a></li>
                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                    @foreach($pages as $k => $data)
                        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                    @endforeach
                    <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                </ul>
            </nav>
        </div>
    </div>
