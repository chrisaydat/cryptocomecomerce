@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <div class="policy-section pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="dashboard-area">
                        <div class="panel-card-header section--bg text-white">
                            {{@$policy->data_values->heading}}
                        </div>
                        <div class="panel-card-body">
                            @php
                                echo @$policy->data_values->description;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
