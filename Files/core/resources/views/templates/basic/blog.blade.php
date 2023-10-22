@extends($activeTemplate.'layouts.frontend')
@section('content')

    <main class="main">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections">
            @include($activeTemplate.'partials.breadcrumb')

            <div class="blog-section pb-60">
                <div class="container">
                    <div class="row mb-30-none">
                        <div class="col-xl-12">
                            <div class="row">
                                @forelse($blogElements as $item)
                                    <div class="col-lg-4 col-md-6 mb-30">
                                        <div class="blog-item">
                                            <div class="blog-thumb">
                                                <img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'1280x500') }}" alt="@lang('blog')">
                                            </div>
                                            <div class="blog-content">
                                                <span class="blog-date text-white"><i class="las la-calendar"></i> {{showDateTime($item->created_at,'M d, Y')}}</span>
                                                <h3 class="title text-white"><a href="{{ route('blog.details',[$item->id,slug(__(@$item->data_values->title))]) }}">{{ shortDescription(strip_tags(__(@$item->data_values->title)),80) }}</a></h3>
                                                <p>{{ shortDescription(strip_tags(__(@$item->data_values->description_nic)),200) }}</p>
                                                <div class="blog-btn">
                                                    <a href="{{ route('blog.details',[$item->id,slug(__(@$item->data_values->title))]) }}" class="custom-btn">@lang('Read More') <i class="las la-angle-double-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty

                                @endforelse
                            </div>
                        </div>

                    </div>
                    <nav>
                        <ul class="pagination">
                            {{$blogElements->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    </main>
@endsection
