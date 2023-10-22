@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="col-lg-12 form-group">
            @php echo $captcha @endphp
    </div>
    <div class="col-lg-12 form-group">
        <input type="text" class="form-control form--control" name="captcha" placeholder="@lang('Enter code')">
    </div>
@endif
