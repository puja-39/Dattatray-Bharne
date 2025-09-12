@extends('backend.auth.layout')

@section('page_title'){{ translate('Forgot Password') }}@stop

@section('content')
    <h4 class="text-center">{{ translate('Signin To Your Account') }}</h4>
    <form action="{{ url('/admin') }}" class="data-parsley-validate auth-login-form mt-2" method="post">
        <div class="form-group">
            <label for="username">{{ translate('Username') }} <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" placeholder="{{ translate('Enter Your Username') }}" required />
        </div>
        <button type="submit" class="btn ripple btn-main-primary btn-block" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('Please Wait...') }}">{{ translate('Sign In') }}</button>
    </form>
    <?php if(app_setting('app_forgot_password','off')=='on'){ ?>
        <div class="mt-3 text-center">
            <p class="mb-1"><a href="{{ route('admin.login') }}"><?php echo translate('Remember Password ?'); ?></a></p>
        </div>
    <?php } ?>
@endsection

<?php /*if(app_setting('captcha_status','off')!='off'){ ?>
    @section('script')
        <?php $captcha_type = app_setting('captcha_status','default'); ?>
        <?php $details = app_setting('captcha_details');
        $details = json_decode($details); ?>
        <script>
            function regenerate_captcha(){
                <?php if($captcha_type=='default'){ ?>
                    $.post('<?php //echo home_site_url('api/web') ?>',{action:'generate_captcha', type:'login_captcha'},function(data) {
                        if(data.status){
                            $("#login_captcha").attr('src',data.details);
                            $("#txt_login_captcha").val('');
                        }
                    });
                <?php }else if($captcha_type=='gv2'){ ?>
                    var grcid = 'login_captcha';
                    $("#txt_captch_error_"+grcid).val('');
                    grecaptcha.reset();
                <?php }else if($captcha_type=='gv3'){ ?>
                    grecaptcha.ready(function() {
                        grecaptcha.execute('<?php echo $details->site ?>', {action: 'login'}).then(function(token) {
                            if($(".captcha-token").length){
                                $(".captcha-token").each(function(){
                                    $(this).val(token);
                                });
                            }
                        });
                    });
                <?php }else if($captcha_type=='turnstile'){ ?>
                    turnstile.ready(function () {
                        turnstile.render('.cf-turnstile', {
                            sitekey: '<?php echo $details->site ?>',
                            callback: function(token) {
                                if($(".captcha-token").length){
                                    $(".captcha-token").each(function(){
                                        $(this).val(token);
                                    });
                                }
                            },
                        });
                    });
                <?php } ?>
            }
        </script>
        <?php if($captcha_type=='gv3' || $captcha_type=='turnstile'){ ?>
            <script>
                $(document).ready(function() {
                    regenerate_captcha();
                });
            </script>
        <?php } ?>
    @endsection
<?php }*/ ?>
