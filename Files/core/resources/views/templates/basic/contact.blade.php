@extends($activeTemplate.'layouts.frontend')

@section('content')
@php
    $contactContent = getContent('contact_us.content',true);
@endphp
<main class="main">

    <section class="all-sections">
        @include($activeTemplate.'partials.breadcrumb')
        <div class="contact-section">
            <div class="container">
                <div class="contact-area">
                    <div class="row justify-content-center mb-30-none">
                        <div class="col-lg-4 mb-30">
                            <div class="contact-info-item-area mb-40-none">
                                <div class="contact-info-header mb-30">
                                    <h3 class="header-title">{{__(@$contactContent->data_values->heading_one)}}</h3>
                                </div>
                                @foreach($contactElement as $item)
                                    <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                                        <div class="contact-info-icon">
                                            @php echo @$item->data_values->icon @endphp
                                        </div>
                                        <div class="contact-info-content">
                                            <h3 class="title">{{__(@$item->data_values->heading)}}</h3>
                                            <p>{{__(@$item->data_values->details)}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-8 mb-30">
                            <div class="contact-form-area">
                                <h3 class="title">{{__(@$contactContent->data_values->heading_two)}}</h3>
                                <form class="contact-form" method="post">
                                    @csrf
                                    <div class="row justify-content-center mb-10-none">
                                        <div class="col-lg-12 form-group">
                                            <input type="text" name="name" value="@if(auth()->user()) {{ auth()->user()->fullname }} @endif" class="form-control" placeholder="@lang('Your name')" @if(auth()->user()) readonly @endif required>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <input type="email" name="email" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" class="form-control" placeholder="@lang('Your email')" @if(auth()->user()) readonly @endif required>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <input type="text" name="subject" value="{{old('subject')}}" class="form-control" placeholder="@lang('Your subject')">
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <textarea class="form-control" name="message" placeholder="@lang('Your message')">{{old('message')}}</textarea>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <button type="submit" class="submit-btn">@lang('Send Message')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="map-section ptb-60">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="maps" id="map"></div>
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

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{@$contactContent->data_values->map_key}}&callback=initMap&libraries=&v=weekly" async></script>
<script>
    // Initialize and add the map
    function initMap() {
    // The location of Uluru
    const uluru = { lat: {{@$contactContent->data_values->latitude}}, lng: {{@$contactContent->data_values->longitude}} };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map,
    });
    }
</script>
@endpush
