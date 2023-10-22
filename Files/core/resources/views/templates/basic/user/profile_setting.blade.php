@extends($activeTemplate.'layouts.frontend')
@section('content')

    <main class="main-section">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start All-sections
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="all-sections pb-60">

            @include($activeTemplate.'partials.breadcrumb')

            <div class="container">
                <div class="row mb-30-none">

                    @include($activeTemplate.'user.partials.sidenav')

                    <div class="col-xl-9 mb-30">
                        <div class="body-wrapper">

                            @include($activeTemplate.'user.partials.dashboard_header')
                            <form class="panel-form" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="user-profile-area mt-30">
                                    <div class="row justify-content-center mb-30-none">
                                        <div class="col-xl-6 mb-30">
                                            <div class="panel panel-default">
                                                <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="panel-title"><i class="las la-user"></i> @lang('User Details')</div>
                                                    <div class="panel-options">
                                                        <a href="javascript:void(0)" data-rel="collapse"><i class="las la-chevron-circle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="panel-body-inner">
                                                        <div class="profile-thumb-area text-center">
                                                            <div class="profile-thumb">
                                                                <div class="image-preview bg_img" data-background="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}">
                                                                </div>
                                                            </div>
                                                            <div class="profile-edit">
                                                                <input type="file" name="image" id="imageUpload" class="upload"
                                                                    accept=".png, .jpg, .jpeg">
                                                                <div class="rank-label">
                                                                    <label for="imageUpload" class="imgUp bg--base">
                                                                        @lang('Upload Image')
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="profile-content-area text-center mt-20">
                                                                <h3 class="name text-white font-weight-normal">{{ $user->fullname }}</h3>
                                                                <h5 class="email text-white font-weight-normal">@lang('E-Mail') : {{$user->email}}</h5>
                                                                <h5 class="phone text-white font-weight-normal">@lang('Phone') : {{$user->mobile}}</h5>
                                                                <h5 class="adress text-white font-weight-normal">@lang('Address') : {{@$user->address->address}}</h5>
                                                                <h5 class="reference text-white font-weight-normal">@lang('Country') : {{@$user->address->country}}</h5>

                                                                <a href="{{ route('user.change.password') }}" class="btn btn--success text-white btn-rounded btn-block btn-icon icon-left mt-20"
                                                                    data-clipboard-text="bbakaHwKsaMc">
                                                                    <i class="las la-clipboard-check"></i> @lang('Change Password')
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 mb-30">
                                            <div class="panel panel-default">
                                                <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="panel-title"><i class="las la-user"></i> @lang('User Form')</div>
                                                    <div class="panel-options-form">
                                                        <a href="javascript:void(0)" data-rel="collapse"><i class="las la-chevron-circle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-form-area">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12 form-group">
                                                            <label>@lang('First Name')*</label>
                                                            <input type="text" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" class="form--control" required>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>@lang('Last Name')*</label>
                                                            <input type="text"  name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" class="form--control" required>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>@lang('Adress')*</label>
                                                            <input type="text" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" class="form--control">
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>@lang('State')*</label>
                                                            <input type="text" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" class="form--control" required>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>@lang('State')*</label>
                                                            <input type="text" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" class="form--control" required>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <button type="submit" class="submit-btn">@lang('Submit Now')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
