@php
    $footerContent = getContent('footer.content',true);
@endphp
    <footer class="footer-section pt-40">
        <div class="container">
            <div class="footer-ribon">@lang('Get In Touch')</div>
            <div class="footer-top-area">
                <div class="row justify-content-center">
                    <div class="col-xl-12 text-center">
                        <div class="footer-widget widget-menu">
                            <div class="footer-logo">
                                <a href="{{route('home')}}"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="@lang('logo')"></a>
                            </div>
                            <div class="social-area">
                                <ul class="footer-social text-center">
                                    @foreach ($socialElements as $item)
                                        <li><a href="{{@$item->data_values->url}}">@php echo @$item->data_values->social_icon @endphp</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('ABOUT COMPANY')</h3>
                        <p>{{__(@$footerContent->data_values->details)}}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('Quick Links')</h3>
                        <ul class="footer-links">
                            <li><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                            <li><a href="{{route('products')}}">@lang('Products')</a></li>
                            <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('Company Policy')</h3>
                        <ul class="footer-links">
                            @foreach ($policyElements as $item)
                                <li>
                                    <a href="{{ route('policy', [$item->id, slug($item->data_values->heading)]) }}">@lang(@$item->data_values->heading)</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('CONTACT INFO')</h3>
                        <ul class="footer-links">
                            @foreach($contactElement as $item)
                                <li>
                                    <span class="contact-info-label">{{__(@$item->data_values->heading)}}:</span>
                                    <p>{{__(@$item->data_values->details)}}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom-area">
                <div class="copyright-area d-flex flex-wrap align-items-center justify-content-center">
                    <div class="copyright">
                        <p>{{__(@$footerContent->data_values->footer_text)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
