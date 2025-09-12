@extends('backend.auth.layout')
@section('page_title'){{ translate('Login') }}@stop
@section('content')
    <h4 class="text-center">{{ translate('Signin To Your Account') }}</h4>
    <form action="{{ route('admin.check_login') }}" class="data-parsley-validate auth-login-form mt-2" method="post">
        <div class="form-group">
            <label for="username">{{ translate('Username') }} <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" placeholder="{{ translate('Enter Your Username') }}" required />
        </div>
        <div class="form-group">
            <label for="password">{{ translate('Password') }} <span class="text-danger">*</span>  </label>
            <input type="password" name="password" class="form-control" placeholder="{{ translate('Enter Your Password') }}" required />
        </div>
        <div class="form-group">
        <label for="captcha">{{ translate('Captcha') }} <span class="text-danger">*</span> <small class="text-muted" style="font-size: 8px;">(Click on image to regenerate new captcha)</small></label>
        <div class="row">
            <div class="col-md-9">
                <input type="text" name="captcha" class="form-control" placeholder="{{ translate('Enter Captcha') }}" required>
            </div>
            <div class="col-md-3">
                <div class="captcha">
                    <span><img src="{{ $captcha }}" alt="captcha" id="captchaImage"  onclick="reloadCaptcha()" style="cursor: pointer; height: 32px; width: 75px;"></span>
                </div>
            </div>
        </div>
    </div>
        <button type="submit" class="btn ripple btn-main-primary btn-block" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('Please Wait...') }}">{{ translate('Sign In') }}</button>
    </form>
    <?php if(app_setting('app_forgot_password','off')=='on'){ ?>
        <div class="mt-3 text-center">
            <p class="mb-1"><a href="{{ route('admin.forgot_password') }}"><?php echo translate('Forgot Password ?'); ?></a></p>
        </div>
    <?php } ?>
@endsection
<script>
    function reloadCaptcha() {
        fetch("{{ route('admin.reload.captcha') }}")
            .then(response => response.text())
            .then(data => {
                document.getElementById('captchaImage').src = data;
            })
            .catch(error => {
                console.error("Captcha reload failed:", error);
            });
    }
</script>
