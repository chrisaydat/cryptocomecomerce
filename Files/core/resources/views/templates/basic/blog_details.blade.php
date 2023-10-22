@extends($activeTemplate.'layouts.frontend')
@section('content')

<main class="main">
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start All-sections
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="all-sections">
        @include($activeTemplate.'partials.breadcrumb')
        <div class="blog-details-section blog-section pb-60">
            <div class="container">
                <div class="row mb-30-none">
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-xl-12 mb-30">
                                <div class="blog-item">
                                    <div class="blog-thumb">
                                        <img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'1280x500') }}" alt="@lang('blog')">
                                    </div>
                                    <div class="blog-content">
                                        <span class="blog-date text-white"><i class="las la-calendar"></i> {{showDateTime($blog->created_at,'M d, Y')}}</span>
                                        <h3 class="title text-white">{{__(@$blog->data_values->title)}}</h3>
                                        @php echo @$blog->data_values->description_nic @endphp
                                    </div>
                                </div>
                                <div class="blog-social-area d-flex flex-wrap justify-content-between align-items-center">
                                    <h3 class="title">@lang('Share This Post')</h3>
                                    <ul class="blog-social">
                                        <li><a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug(@$blog->data_values->title)}}"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="http://twitter.com/share?text={{slug(@$blog->data_values->title)}}&url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug(@$blog->data_values->title)}}"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug(@$blog->data_values->title)}}"><i class="fab fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-30">
                        <div class="sidebar">
                            <div class="widget-box mb-30">
                                <h5 class="widget-title">@lang('Latest Posts')</h5>
                                <div class="popular-widget-box">
                                    @forelse($blogElements as $item)
                                        <div class="single-popular-item d-flex flex-wrap align-items-center">
                                            <div class="popular-item-thumb">
                                                <img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'1280x500') }}" alt="@lang('blog')">
                                            </div>
                                            <div class="popular-item-content">
                                                <h5 class="title"><a href="{{ route('blog.details',[$item->id,slug(__(@$item->data_values->title))]) }}">{{ shortDescription(strip_tags(__(@$item->data_values->title)),30) }}</a></h5>
                                                <span class="blog-date">{{showDateTime($blog->created_at,'M d, Y')}}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="single-popular-item d-flex flex-wrap align-items-center">

                                            <div class="popular-item-content">
                                                <h5 class="title">@lang('No data found')</h5>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
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

@push('shareImage')
    {{--<!-- Google / Search Engine Tags -->--}}
    <meta itemprop="name" content="{{ __(@$blog->data_values->title) }}">
    <meta itemprop="description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta itemprop="image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'1280x500') }}">

    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'1280x500') }}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __(@$blog->data_values->title) }}">
    <meta property="og:description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta property="og:image:type" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'1280x500') }}" />
    <meta property="og:image:width" content="1280" />
    <meta property="og:image:height" content="500" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush
